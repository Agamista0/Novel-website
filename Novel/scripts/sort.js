const showMoreBtn = document.getElementById('showMoreBtn');
const chaptersContainer = document.querySelector('.chapters');
const chapters = document.querySelectorAll('.chapter-row');
 
function toggleChapters() {
    chapters.forEach((chapter, index) => {
        if (index >= 10) {
            chapter.classList.add('hidden');
        }
    });
}

toggleChapters();

showMoreBtn.addEventListener('click', function() {
    chapters.forEach((chapter) => {
        chapter.classList.remove('hidden');
     });
    this.style.display = 'none';
 });

document.addEventListener('DOMContentLoaded', function() {
    const arrowIcon = document.querySelector('.fa-arrow-up-wide-short');
    let ascendingOrder = true;

    arrowIcon.addEventListener('click', function() {
        const chapters = Array.from(chaptersContainer.querySelectorAll('.chapter-row'));

        ascendingOrder = !ascendingOrder;

        chapters.sort(function(a, b) {
            const timeA = new Date(a.getAttribute('data-time')).getTime();
            const timeB = new Date(b.getAttribute('data-time')).getTime();

            if (ascendingOrder) {
                return timeB - timeA;

            } else {
                return timeA - timeB;

            }
        });

        chapters.forEach(function(chapter) {
            chaptersContainer.appendChild(chapter);
        });
    });
});
