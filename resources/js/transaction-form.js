

document.addEventListener('DOMContentLoaded', function () {
  // JavaScript to handle recalculation when the new quantity changes
  function updateTotal() {
    let newQuantity = document.getElementById('newQuantity').value;

    // Emit event to Livewire to recalculate total
    Livewire.emit('recalculateTotal', newQuantity);
  }

  // Add event listener for the new quantity input
  const newQuantityInput = document.getElementById('newQuantity');
  if (newQuantityInput) {
    newQuantityInput.addEventListener('input', updateTotal);
  }
});


// alert('alert from transaction-form.js');
console.log('console.log from transaction-form.js');
