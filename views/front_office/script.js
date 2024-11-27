const paymentForm = document.getElementById('payment-form');
const loadingOverlay = document.getElementById('loading-overlay');
const amountInput = document.getElementById('amount');

// Format the amount field to show currency
amountInput.addEventListener('input', (event) => {
  let value = event.target.value.replace(/[^0-9.]/g, '');
  event.target.value = value ? `$${parseFloat(value).toFixed(2)}` : '';
});

paymentForm.addEventListener('submit', function(event) {
  event.preventDefault();

  loadingOverlay.style.display = 'flex';

  setTimeout(() => {
    loadingOverlay.style.display = 'none';
    alert('Payment Successful!');
  }, 3000);
});
