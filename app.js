class RecipeApp {
    constructor() {
        this.recipes = [];
        this.currentUser = null;
        this.initEventListeners();
    }

    initEventListeners() {
        // Navigation listeners
        document.getElementById('home-link').addEventListener('click', () => this.loadHomePage());
        document.getElementById('recipes-link').addEventListener('click', () => this.loadRecipesPage());
        document.getElementById('login-link').addEventListener('click', () => this.showLoginModal());
        document.getElementById('register-link').addEventListener('click', () => this.showRegisterModal());

        // Modal close buttons
        document.querySelectorAll('.close').forEach(closeBtn => {
            closeBtn.addEventListener('click', () => {
                document.getElementById('auth-modal').style.display = 'none';
                document.getElementById('recipe-modal').style.display = 'none';
            });
        });
    }

    loadHomePage() {
        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="hero">
                <h1>Welcome to Recipe Sharing</h1>
                <p>Discover and share amazing recipes!</p>
                <button class="btn" id="explore-recipes">Explore Recipes</button>
            </div>
        `;
        document.getElementById('explore-recipes').addEventListener('click', () => this.loadRecipesPage());
    }

    loadRecipesPage() {
        const content = document.getElementById('content');
        content.innerHTML = `
            <div class="recipes-container">
                <h2>Recipes</h2>
                <button class="btn" id="create-recipe-btn">Create Recipe</button>
                <div class="recipe-grid" id="recipe-grid">
                    <!-- Recipes will be dynamically added here -->
                </div>
            </div>
        `;

        document.getElementById('create-recipe-btn').addEventListener('click', () => this.showRecipeModal());
        this.fetchAndDisplayRecipes();
    }

    fetchAndDisplayRecipes() {
        // Simulated recipe data
        const mockRecipes = [
            {
                id: 1,
                title: 'Pasta Carbonara',
                description: 'Classic Italian pasta dish',
                ingredients: ['Pasta', 'Eggs', 'Bacon', 'Parmesan'],
                instructions: 'Mix ingredients and cook'
            },
            {
                id: 2,
                title: 'Chocolate Cake',
                description: 'Delicious chocolate cake',
                ingredients: ['Flour', 'Cocoa', 'Sugar', 'Eggs'],
                instructions: 'Mix and bake'
            }
        ];

        const recipeGrid = document.getElementById('recipe-grid');
        mockRecipes.forEach(recipe => {
            const recipeCard = document.createElement('div');
            recipeCard.classList.add('recipe-card');
            recipeCard.innerHTML = `
                <h3>${recipe.title}</h3>
                <p>${recipe.description}</p>
                <button class="btn" onclick="app.viewRecipeDetails(${recipe.id})">View Details</button>
            `;
            recipeGrid.appendChild(recipeCard);
        });
    }

    showLoginModal() {
        const authFormContainer = document.getElementById('auth-form-container');
        authFormContainer.innerHTML = `
            <h2>Login</h2>
            <form id="login-form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        `;
        document.getElementById('auth-modal').style.display = 'block';
        
        document.getElementById('login-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.login();
        });
    }

    showRegisterModal() {
        const authFormContainer = document.getElementById('auth-form-container');
        authFormContainer.innerHTML = `
            <h2>Register</h2>
            <form id="register-form">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
        `;
        document.getElementById('auth-modal').style.display = 'block';
    }

    showRecipeModal() {
        const recipeFormContainer = document.getElementById('recipe-form-container');
        recipeFormContainer.innerHTML = `
            <h2>Create Recipe</h2>
            <form id="recipe-form">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea required></textarea>
                </div>
                <div class="form-group">
                    <label>Ingredients</label>
                    <textarea required></textarea>
                </div>
                <div class="form-group">
                    <label>Instructions</label>
                    <textarea required></textarea>
                </div>
                <button type="submit" class="btn">Create Recipe</button>
            </form>
        `;
        document.getElementById('recipe-modal').style.display = 'block';
    }

    viewRecipeDetails(recipeId) {
        // Implement recipe details view
        alert(`Viewing recipe details for recipe ${recipeId}`);
    }

    login() {
        // Simulate login
        this.currentUser = { username: 'John Doe' };
        document.getElementById('auth-modal').style.display = 'none';
        alert('Logged in successfully!');
    }
}

// Initialize the app
const app = new RecipeApp();
app.loadHomePage();
