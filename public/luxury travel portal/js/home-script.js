
setTimeout(() => {
    const slider = document.querySelectorAll('.mySwiper');
    if(slider.length >0){
      const btnNest = slider[0].swiperParams
    }
  }, 1000)

  function tableText() {
    var pTag = document.querySelectorAll(".slice"); 
    if(pTag.length > 0){
      for (var i = 0; i < pTag.length; i++) {
        if (pTag[i].innerHTML.length > 12) { 
          var shorten = pTag[i].innerHTML.substring(0, 12) + "..."; 
          pTag[i].innerHTML = shorten; 
        }
      }
    }
  }

  function shortenText() {
    if (window.innerWidth < 575) { 
      tableText(); 
    }
  }
  shortenText();

  const company = document.querySelector('.company-form');
  const contact = document.querySelector('.contact-form');
  const companyForm = document.querySelector('.company');
  const contactForm = document.querySelector('.contact');

  if(company != null){
    
    company.addEventListener('click', () => {
      companyForm.style.display = 'flex';
      contactForm.style.display = 'none';

      if (window.innerWidth < 768) { 
        company.style.color = '#fff';
        contact.style.color = 'rgba(255, 255, 255, 0.5)';
      }else{
        company.style.color = '#a65a3f';
        contact.style.color = '#0b3841';
      }
    });

    contact.addEventListener('click', () => {
      companyForm.style.display = 'none';
      contactForm.style.display = 'flex';

      if (window.innerWidth < 768) { 
        contact.style.color = '#fff';
        company.style.color = 'rgba(255, 255, 255, 0.5)';
      }else{
        contact.style.color = '#a65a3f';
        company.style.color = '#0b3841';
      }


    });
  }

