document.addEventListener('DOMContentLoaded', function() {
    const showMoreBtn = document.getElementById('showMoreBtn');
    const chapters = document.querySelectorAll('.chapter-row');
    const initialCount = 10; // Number of chapters to show initially

    // Hide all chapters except for the first initialCount
    for (let i = initialCount; i < chapters.length; i++) {
        chapters[i].style.display = 'none';
    }

    showMoreBtn.addEventListener('click', function() {
        // Toggle the visibility of the remaining chapters
        for (let i = initialCount; i < chapters.length; i++) {
            chapters[i].style.display = chapters[i].style.display === 'none' ? 'flex' : 'none';
        }

        // Update button text based on visibility
        const buttonText = showMoreBtn.innerText.trim();
        showMoreBtn.innerText = buttonText === 'Show more' ? 'Show less' : 'Show more';
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const arrowButton = document.querySelector('.fa-arrow-up-wide-short');
    const chaptersContainer = document.querySelector('.chapters');

    let sortOrder = 'newest'; // Initial sorting order

    arrowButton.addEventListener('click', function() {
        // Toggle the sorting order
        sortOrder = sortOrder === 'newest' ? 'oldest' : 'newest';

        // Sort chapters based on the sorting order
        const sortedChapters = sortChapters(chaptersContainer.querySelectorAll('.chapter-row'));

        // Update the HTML with the sorted chapters
        chaptersContainer.innerHTML = '';
        sortedChapters.forEach(chapter => {
            chaptersContainer.appendChild(chapter);
        });
    });

    function sortChapters(chapters) {
        // Convert NodeList to array for sorting
        const chaptersArray = Array.from(chapters);

        // Sorting logic based on sortOrder
        chaptersArray.sort(function(a, b) {
            const timeA = new Date(a.getAttribute('data-time')).getTime();
            const timeB = new Date(b.getAttribute('data-time')).getTime();

            if (sortOrder === 'newest') {
                return timeB - timeA;
            } else {
                return timeA - timeB;
            }
        });

        return chaptersArray;
    }
});