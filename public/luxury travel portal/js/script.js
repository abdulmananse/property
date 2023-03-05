// paginacija 
const cardsPerPage = 9;
const cardsContainer = document.querySelector('.properties-card');
const cards = Array.from(cardsContainer.querySelectorAll('.card-info'));
const pagination = document.querySelector('.pagination');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
let currentPage = 1;

function showCards(page) {
  const start = (page - 1) * cardsPerPage;
  const end = start + cardsPerPage;
  cards.forEach((card, index) => {
    if (index >= start && index < end) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }

  });
}

function showPageNumbers() {
  const totalPages = Math.ceil(cards.length / cardsPerPage);
  pagination.innerHTML = '';
  for (let i = 1; i <= totalPages; i++) {
    const page = document.createElement('span');
    page.textContent = i;
    if (i === currentPage) {
      page.classList.add('current-page');
    }
    pagination.appendChild(page);
    



  }
}

prevBtn.addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    showCards(currentPage);
    showPageNumbers();
  }

  if (currentPage == 1) {
    prevBtn.style.color = '#fff8f0';
    nextBtn.style.color = '#0b3841';

  }else{
    prevBtn.style.color = '#0b3841';
    nextBtn.style.color = '#0b3841';
  }
});

nextBtn.addEventListener('click', () => {
  if (currentPage < Math.ceil(cards.length / cardsPerPage)) {
    currentPage++;
    showCards(currentPage);
    showPageNumbers();

    if (currentPage == Math.ceil(cards.length / cardsPerPage)) {
      nextBtn.style.color = '#fff8f0';
      prevBtn.style.color = '#0b3841';

    }else{
      nextBtn.style.color = '#0b3841';
      prevBtn.style.color = '#0b3841';
    }

  }
});

pagination.addEventListener('click', (event) => {
  if (event.target.tagName === 'SPAN') {
    currentPage = parseInt(event.target.textContent);
    showCards(currentPage);
    showPageNumbers();
  }
});

showCards(currentPage);
showPageNumbers();


const propertyFilter = document.querySelector('.property-filter');
const showFilter = document.querySelector('.show-filter');

showFilter.addEventListener('click', () => {
  propertyFilter.classList.toggle('active');
})


const download = document.querySelector('.download');
const request = document.querySelector('.request');

const downloadCard = document.querySelector('.download-card-open');
const downloadCardRequest = document.querySelector('.download-card-request-open');


download.addEventListener('click', () => {
  downloadCard.classList.add('active');
})

request.addEventListener('click', () => {
  downloadCardRequest.classList.add('active');
})

arrowBackDownloadd = document.querySelector('.arrow-back');
arrowBackRequest = document.querySelector('.arrow-back-request');

arrowBackDownloadd.addEventListener('click', () => {
  downloadCard.classList.remove('active');
})

arrowBackRequest.addEventListener('click', () => {
  downloadCardRequest.classList.remove('active');

})



const dropdown = document.querySelectorAll('.dropdown-open');
const selected = document.querySelectorAll('.select-destionation');

for(const select of selected){

  select.addEventListener('click', () => {
    const dropOpen = select.nextElementSibling;
    dropOpen.classList.toggle('active');
  })
}



