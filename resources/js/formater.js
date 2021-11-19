window.onload = function() {
    
  };

  function formatter(element){
    element.value = element.value.replaceAll(',','');
    element.value = element.value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}