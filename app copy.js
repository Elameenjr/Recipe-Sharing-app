/**
 * CookConnect - Recipe Sharing Application
 * Main JavaScript file for handling all app functionality
 */

class CookConnectApp {
    constructor() {
        this.recipes = [];
        this.currentUser = null;
        this.isLoggedIn = false;
        
        // Initialize the application
        this.initEventListeners();
        this.loadMockData();
    }

    /**
     * Initialize all event listeners for the application
     */
    initEventListeners() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Get Started button
        const getStartedBtn = document.getElementById('getStartedBtn');
        if (getStartedBtn) {
            getStartedBtn.addEventListener('click', (e) => {
                e.preventDefault();
                // Scroll to recipe submission section
                const recipeSubmission = document.querySelector('.py-12.bg-white');
                if (recipeSubmission) {
                    recipeSubmission.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Watch Demo button
        const watchDemoBtn = document.getElementById('watchDemoBtn');
        if (watchDemoBtn) {
            watchDemoBtn.addEventListener('click', () => {
                this.openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ');
            });
        }

        // Close modal button
        const closeModal = document.getElementById('closeModal');
        if (closeModal) {
            closeModal.addEventListener('click', () => {
                this.closeVideoModal();
            });
        }

        // Recipe submission form
        const recipeForm = document.querySelector('form button[type="submit"]');
        if (recipeForm) {
            recipeForm.addEventListener('click', (e) => {
                e.preventDefault();
                // this.submitRecipe();
            });
        }

        // Add event listeners to all recipe video play buttons
        document.querySelectorAll('.recipe-overlay button').forEach(button => {
            button.addEventListener('click', () => {
                this.openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ');
            });
        });

        // Add event listeners to all video tutorial play buttons
        document.querySelectorAll('.h-48.relative.group.cursor-pointer').forEach(element => {
            element.addEventListener('click', () => {
                const videoUrl = element.getAttribute('onclick').match(/'([^']+)'/)[1];
                this.openVideoModal(videoUrl);
                // Prevent the default onclick attribute from firing
                element.removeAttribute('onclick');
            });
        });

        // Add event listeners to heart buttons (favorites)
        document.querySelectorAll('.text-red-500.hover\\:text-red-600').forEach(button => {
            button.addEventListener('click', (e) => {
                const heartIcon = e.currentTarget.querySelector('i');
                if (heartIcon.classList.contains('far')) {
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                } else {
                    heartIcon.classList.remove('fas');
                    heartIcon.classList.add('far');
                }
            });
        });

        // Add event listeners to rating stars
        document.querySelectorAll('.focus\\:outline-none.text-yellow-400, .focus\\:outline-none.text-gray-300').forEach(star => {
            star.addEventListener('click', (e) => {
                const stars = e.currentTarget.parentElement.querySelectorAll('button');
                const clickedIndex = Array.from(stars).indexOf(e.currentTarget);
                
                stars.forEach((s, index) => {
                    const starIcon = s.querySelector('i');
                    if (index <= clickedIndex) {
                        starIcon.classList.add('text-yellow-400');
                        starIcon.classList.remove('text-gray-300');
                    } else {
                        starIcon.classList.remove('text-yellow-400');
                        starIcon.classList.add('text-gray-300');
                    }
                });
            });
        });

        // Chat message input
        const chatInput = document.querySelector('.p-4.bg-white input[type="text"]');
        const sendButton = document.querySelector('.p-4.bg-white button.ml-2');
        
        if (chatInput && sendButton) {
            // Send message on button click
            sendButton.addEventListener('click', () => {
                this.sendChatMessage(chatInput.value);
                chatInput.value = '';
            });
            
            // Send message on Enter key
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendChatMessage(chatInput.value);
                    chatInput.value = '';
                }
            });
        }

        // Add Recipe button
        const addRecipeBtn = document.querySelector('.bg-red-500.hover\\:bg-red-600.text-white.px-4.py-2.rounded-md');
        if (addRecipeBtn) {
            addRecipeBtn.addEventListener('click', () => {
                // Scroll to recipe submission section
                const recipeSubmission = document.querySelector('.py-12.bg-white');
                if (recipeSubmission) {
                    recipeSubmission.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }
    }

    /**
     * Load mock data for the application
     */
    loadMockData() {
        // Mock recipes data
        this.recipes = [
            {
                id: 1,
                title: 'Creamy Garlic Pasta',
                chef: 'Chef Maria',
                time: '25 min',
                rating: 4.5,
                reviews: 243,
                difficulty: 'Beginner',
                servings: 4,
                image: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836'
            },
            {
                id: 2,
                title: 'BBQ Ribs',
                chef: 'Chef Michael',
                time: '3 hrs',
                rating: 5.0,
                reviews: 512,
                difficulty: 'Advanced',
                servings: 6,
                image: 'https://images.unsplash.com/photo-1544025162-d76694265947'
            },
            {
                id: 3,
                title: 'Rainbow Salad Bowl',
                chef: 'Chef Emily',
                time: '15 min',
                rating: 5.0,
                reviews: 194,
                difficulty: 'Easy',
                servings: 2,
                image: 'https://images.unsplash.com/photo-1481931098730-318b6f776db0'
            }
        ];
    }

    /**
     * Open the video modal with the specified URL
     * @param {string} videoUrl - The URL of the video to display
     */
    openVideoModal(videoUrl) {
        const modal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');
        
        if (modal && videoFrame) {
            videoFrame.src = videoUrl;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    /**
     * Close the video modal
     */
    closeVideoModal() {
        const modal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');
        
        if (modal && videoFrame) {
            videoFrame.src = '';
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    /**
     * Submit a new recipe from the form
     */
    submitRecipe() {
        // Get form values
        const recipeName = document.getElementById('recipe-name')?.value;
        const description = document.getElementById('description')?.value;
        const prepTime = document.getElementById('prep-time')?.value;
        const cookTime = document.getElementById('cook-time')?.value;
        const servings = document.getElementById('servings')?.value;
        const difficulty = document.querySelector('input[name="difficulty"]:checked')?.nextElementSibling?.textContent.trim();
        const ingredients = document.getElementById('ingredients')?.value;
        const instructions = document.getElementById('instructions')?.value;

        // Validate form
        if (!recipeName || !description || !prepTime || !cookTime || !servings || !ingredients || !instructions) {
            alert('Please fill in all required fields');
            return;
        }

        // Create new recipe object
        const newRecipe = {
            id: this.recipes.length + 1,
            title: recipeName,
            chef: this.currentUser ? this.currentUser.username : 'Anonymous Chef',
            time: parseInt(prepTime) + parseInt(cookTime) + ' min',
            rating: 0,
            reviews: 0,
            difficulty: difficulty || 'Beginner',
            servings: parseInt(servings),
            image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c',
            description: description,
            ingredients: ingredients.split('\n'),
            instructions: instructions.split('\n')
        };

        // Add to recipes array
        this.recipes.push(newRecipe);

        // Show success message
        alert('Recipe submitted successfully!');

        // Reset form
        document.querySelectorAll('form input, form textarea').forEach(input => {
            input.value = '';
        });
    }

    /**
     * Send a chat message
     * @param {string} message - The message to send
     */
    sendChatMessage(message) {
        if (!message.trim()) return;

        const chatMessages = document.getElementById('chatMessages');
        if (!chatMessages) return;

        // Create new message element
        const newMessage = document.createElement('div');
        newMessage.classList.add('flex', 'items-start', 'justify-end', 'fade-in');
        
        // Get current time
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const formattedTime = `${hours}:${minutes < 10 ? '0' + minutes : minutes} ${hours >= 12 ? 'PM' : 'AM'}`;

        // Set message HTML
        newMessage.innerHTML = `
            <div class="chat-message">
                <div class="bg-red-100 p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                    <p class="text-sm text-gray-800">${message}</p>
                </div>
                <span class="message-time hidden text-xs text-gray-500 mt-1 text-right">${formattedTime}</span>
            </div>
        `;

        // Add to chat container
        chatMessages.appendChild(newMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Simulate response after a delay
        setTimeout(() => {
            this.simulateChatResponse();
        }, 1500);
    }

    /**
     * Simulate a response in the chat
     */
    simulateChatResponse() {
        const chatMessages = document.getElementById('chatMessages');
        if (!chatMessages) return;

        // Create response message
        const responseMessage = document.createElement('div');
        responseMessage.classList.add('flex', 'items-start', 'fade-in');
        
        // Get current time
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const formattedTime = `${hours}:${minutes < 10 ? '0' + minutes : minutes} ${hours >= 12 ? 'PM' : 'AM'}`;

        // Array of possible responses
        const responses = [
            "That's a great question! For best results, try using fresh ingredients.",
            "I recommend adding a pinch of salt to enhance the flavors.",
            "You might want to try a lower temperature for a longer time to get that perfect texture.",
            "That recipe works best with cast iron cookware if you have it available.",
            "Have you tried adding herbs at the end of cooking? It really enhances the aroma!"
        ];

        // Pick a random response
        const randomResponse = responses[Math.floor(Math.random() * responses.length)];

        // Set response HTML
        responseMessage.innerHTML = `
            <img class="h-8 w-8 rounded-full object-cover mr-3" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
            <div class="chat-message">
                <div class="bg-white p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                    <p class="text-sm text-gray-800">${randomResponse}</p>
                </div>
                <span class="message-time hidden text-xs text-gray-500 mt-1">${formattedTime}</span>
            </div>
        `;

        // Add to chat container
        chatMessages.appendChild(responseMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    /**
     * Login a user
     * @param {string} email - User email
     * @param {string} password - User password
     */
    login(email, password) {
        // This would normally validate against a backend
        this.currentUser = {
            username: 'John Doe',
            email: email
        };
        this.isLoggedIn = true;
        
        // Update UI to reflect logged in state
        this.updateUIForLoggedInUser();
    }

    /**
     * Register a new user
     * @param {string} username - Username
     * @param {string} email - User email
     * @param {string} password - User password
     */
    register(username, email, password) {
        // This would normally send data to a backend
        this.currentUser = {
            username: username,
            email: email
        };
        this.isLoggedIn = true;
        
        // Update UI to reflect logged in state
        this.updateUIForLoggedInUser();
    }

    /**
     * Update UI elements for logged in user
     */
    updateUIForLoggedInUser() {
        // Update profile button to show user avatar or initials
        const profileButton = document.querySelector('.bg-white.rounded-full.flex.text-sm');
        if (profileButton) {
            profileButton.innerHTML = `
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-500">
                    <span class="text-sm font-medium leading-none text-white">
                        ${this.currentUser.username.split(' ').map(n => n[0]).join('')}
                    </span>
                </span>
            `;
        }
    }
}

// Initialize the application when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    window.cookConnectApp = new CookConnectApp();

    // Simulate chat message response after a delay
    setTimeout(() => {
        const chatContainer = document.getElementById('chatMessages');
        if (chatContainer) {
            const newMessage = document.createElement('div');
            newMessage.classList.add('flex', 'items-start', 'fade-in');
            
            // Get current time
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const formattedTime = `${hours}:${minutes < 10 ? '0' + minutes : minutes} ${hours >= 12 ? 'PM' : 'AM'}`;
            
            newMessage.innerHTML = `
                <img class="h-8 w-8 rounded-full object-cover mr-3" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                <div class="chat-message">
                    <div class="bg-white p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                        <p class="text-sm text-gray-800">I recommend refrigerating for at least 30 minutes, but ideally 1 hour. This lets the gluten relax and keeps the butter cold for that perfect flakiness!</p>
                    </div>
                    <span class="message-time hidden text-xs text-gray-500 mt-1">${formattedTime}</span>
                </div>
            `;
            
            chatContainer.appendChild(newMessage);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }, 3000);

    // Profile dropdown click-to-toggle support
    const profileMenuButton = document.getElementById('profileMenuButton');
    const profileDropdown = document.getElementById('profileDropdown');
    if (profileMenuButton && profileDropdown) {
        profileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function() {
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
        });
    }

    // Modal logic for Login/Sign Up
    const authModal = document.getElementById('authModal');
    const loginSignupBtn = document.getElementById('loginSignupBtn');
    const closeAuthModal = document.getElementById('closeAuthModal');
    const authForm = document.getElementById('authForm');
    const signupForm = document.getElementById('signupForm');
    const toggleSignup = document.getElementById('toggleSignup');
    const toggleLogin = document.getElementById('toggleLogin');

    if (loginSignupBtn) {
        loginSignupBtn.addEventListener('click', function () {
            authModal.classList.remove('hidden');
            authForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
        });
    }
    if (closeAuthModal) {
        closeAuthModal.addEventListener('click', function () {
            authModal.classList.add('hidden');
        });
    }
    if (toggleSignup) {
        toggleSignup.addEventListener('click', function (e) {
            e.preventDefault();
            authForm.classList.add('hidden');
            signupForm.classList.remove('hidden');
        });
    }
    if (toggleLogin) {
        toggleLogin.addEventListener('click', function (e) {
            e.preventDefault();
            signupForm.classList.add('hidden');
            authForm.classList.remove('hidden');
        });
    }
    // Optional: Close modal when clicking outside the modal content
    if (authModal) {
        authModal.addEventListener('click', function (e) {
            if (e.target === authModal) {
                authModal.classList.add('hidden');
            }
        });
    }
});
