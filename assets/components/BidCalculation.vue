<script>
import axios from 'axios';
import template from '../../templates/bid_calculation/BidCalculationToolTemplate.html';

export default {
  template: template,
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

      setTimeout(() => {
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
      }, 600);
    },
  },
  mounted() {
    this.fetchFees();
  },
};
</script>
