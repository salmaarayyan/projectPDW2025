// Recipe Filter
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const recipeCards = document.querySelectorAll('[data-category]');
            
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filter = this.getAttribute('data-filter');
                    
                    recipeCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
            
            // Search functionality
            const searchForm = document.getElementById('search-form');
            const searchInput = document.getElementById('search-input');
            
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.toLowerCase();
                // Add your search logic here
                console.log('Searching for:', searchTerm);
            });
            
            // Newsletter form
            const newsletterForm = document.getElementById('newsletter-form');
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Terima kasih telah berlangganan newsletter kami!');
            });
            
            // Back to top button
            const backToTopBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.display = 'block';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });
            
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });