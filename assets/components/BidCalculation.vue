<template>
  <div>
    <h2>Bid Calculation Tool</h2>

    <div>
      <label for="basePrice">Base Price:</label>
      <input
          type="number"
          v-model="price"
          placeholder="Enter vehicle base price"
          @input="onPriceInput"
      />

      <label for="vehicleType">Vehicle Type:</label>
      <select v-model="type">
        <option value="common">Common</option>
        <option value="luxury">Luxury</option>
      </select>
    </div>

    <div v-if="error && priceTouched" class="error">{{ error }}</div>

    <div v-if="totalFees !== null && !error">
      <h3>Calculated Fees</h3>
      <table>
        <tbody>
        <tr>
          <td>Basic Fee:</td>
          <td>{{ fees.basicFee }} $</td>
        </tr>
        <tr>
          <td>Special Fee:</td>
          <td>{{ fees.specialFee }} $</td>
        </tr>
        <tr>
          <td>Association Fee:</td>
          <td>{{ fees.associationFee }} $</td>
        </tr>
        <tr>
          <td>Storage Fee:</td>
          <td>{{ fees.storageFee }} $</td>
        </tr>
        <tr>
          <td><strong>Total Fees:</strong></td>
          <td><strong>{{ totalFees }} $</strong></td>
        </tr>
        <tr>
          <td><strong>Total Price:</strong></td>
          <td><strong>{{ totalFees + price}} $</strong></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      price: 0,
      priceTouched: false,
      type: 'common',
      totalFees: null,
      fees: {
        basicFee: 0,
        specialFee: 0,
        associationFee: 0,
        storageFee: 0,
      },
      error: null,
    };
  },
  watch: {
    price: 'fetchFees',
    type: 'fetchFees',
  },
  methods: {
    onPriceInput() {
      this.priceTouched = true;
    },
    fetchFees() {
      if (this.price <= 0 || isNaN(this.price) && this.priceTouched) {
        this.totalFees = null;
        this.error = 'Please enter a valid price';
        return;
      }

      const params = {
        price: this.price,
        type: this.type,
      };

      const apiKey = process.env.API_KEY;

      axios
          .get('/api/calculate-fees', {
            params,
            headers: {
              'X-API-KEY': apiKey,
            },
          })
          .then((response) => {
            const data = response.data;
            this.totalFees = data.totalFees;
            this.fees.basicFee = data.basicFee;
            this.fees.specialFee = data.specialFee;
            this.fees.associationFee = data.associationFee;
            this.fees.storageFee = data.storageFee;
            this.error = null;
          })
          .catch((error) => {
            if (error.response) {
              this.error = error.response.data.error || 'An error occurred';
            } else if (error.request) {
              this.error = 'Backend not reachable';
            } else {
              this.error = 'An error occurred';
            }
            this.totalFees = null;
          });
    },
  },
  mounted() {
    this.fetchFees();
  },
};
</script>

<style scoped>
.error {
  color: red;
  font-weight: bold;
}
table {
  border-collapse: collapse;
  width: 100%;
}
td {
  padding: 8px;
  border: 1px solid #ddd;
}
</style>
