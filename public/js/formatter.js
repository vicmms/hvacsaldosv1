window.onload = function() {
    const elements = document.querySelectorAll('.formatter');
    elements.forEach(el => {
      console.log(el.textContent)
        if(el.value){
          el.value = el.value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }else{
          el.textContent = el.textContent.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
    });
};

function formatter(element){
  element.value = element.value.replaceAll(',','');
  element.value = element.value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}