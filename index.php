<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CookConnect - Share & Discover Recipes</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom CSS for elements Tailwind can't handle */
        .recipe-card:hover .recipe-overlay {
            opacity: 1;
        }
        .chat-message:hover .message-time {
            display: block;
        }
        #videoModal {
            transition: all 0.3s ease;
        }
        .fade-in {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-utensils text-red-500 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-800">CookConnect</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="#" class="border-red-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Home</a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Recipes</a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Community</a>
                        <a href="#" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Learn</a>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <button
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300 flex items-center"
                        onclick="document.getElementById('submitRecipeSection').scrollIntoView({ behavior: 'smooth' });"
                    >
                        <i class="fas fa-plus mr-2"></i> Add Recipe
                    </button>
                    <!-- Login/Sign Up Button -->
                     <?php if ($isLoggedIn): ?>
                        <div class="bg-green-100 text-green-700 p-3 rounded">Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</div>
                    <?php endif; ?>
                    <button
                        id="loginSignupBtn"
                        class="ml-4 bg-white text-red-600 border border-red-500 hover:bg-red-50 px-4 py-2 rounded-md text-sm font-medium transition duration-300"
                    >
                        Log In / Sign Up
                    </button>
                    <div class="ml-3 relative group">
                        <div>
                            <button id="profileMenuButton" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 p-2" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle text-gray-500 text-xl"></i>
                            </button>
                        </div>
                        <!-- Dropdown menu, show on hover or focus -->
                        <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block group-focus-within:block z-50" id="profileDropdown">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="profileMenuButton">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"><i class="fas fa-user mr-2"></i>Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"><i class="fas fa-book-open mr-2"></i>My Recipes</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"><i class="fas fa-bookmark mr-2"></i>Saved Recipes</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"><i class="fas fa-cog mr-2"></i>Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="#" class="bg-red-50 border-red-500 text-red-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Recipes</a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Community</a>
                <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Learn</a>
                <div class="border-t border-gray-200 pt-4 pb-3">
                    <button class="w-full flex justify-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                        <i class="fas fa-plus mr-2"></i> Add Recipe
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-red-500 to-yellow-500">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
            <div class="text-center lg:text-left lg:w-1/2">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    <span class="block">Share your culinary</span>
                    <span class="block">creations with the world</span>
                </h1>
                <p class="mt-6 max-w-lg text-xl text-red-100 sm:max-w-3xl">
                    Join our community of food lovers, learn new skills, and get inspired by thousands of recipes from home cooks around the globe.
                </p>
                <div class="mt-10 sm:flex sm:justify-center lg:justify-start">
                    <div class="rounded-md shadow">
                        <button id="getStartedBtn" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 transition transform hover:-translate-y-1 duration-300">
                            Get Started <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <button id="watchDemoBtn" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10 transition-all duration-300">
                            <i class="fas fa-play mr-2"></i> Watch Demo
                        </button>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block lg:w-1/2 relative">
                <div class="relative w-full h-96">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-white rounded-xl shadow-2xl p-4 max-w-sm transform rotate-3">
                            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=500&q=60" alt="Jollof Rice" class="rounded-lg w-full h-64 object-cover">
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">Jollof Rice</h3>
                                <div class="flex items-center mt-1">
                                    <div class="flex">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                    </div>
                                    <span class="text-gray-500 text-sm ml-2">4.8 (320 reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="absolute bg-white rounded-xl shadow-2xl p-4 max-w-sm -bottom-10 -left-20 transform -rotate-6">
                            <img src="https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=500&q=60" alt="Egusi Soup" class="rounded-lg w-full h-64 object-cover">
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">Egusi Soup</h3>
                                <div class="flex items-center mt-1">
                                    <div class="flex">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                    </div>
                                    <span class="text-gray-500 text-sm ml-2">5.0 (210 reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipe Categories -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Categories</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Find recipes you'll love
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6">
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-drumstick-bite text-4xl text-red-500 group-hover:text-red-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Meat</h3>
                            <p class="mt-1 text-gray-500 text-xs">237 recipes</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-leaf text-4xl text-green-500 group-hover:text-green-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Vegetarian</h3>
                            <p class="mt-1 text-gray-500 text-xs">512 recipes</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-fish text-4xl text-blue-500 group-hover:text-blue-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Seafood</h3>
                            <p class="mt-1 text-gray-500 text-xs">136 recipes</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-bread-slice text-4xl text-yellow-500 group-hover:text-yellow-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Baked</h3>
                            <p class="mt-1 text-gray-500 text-xs">324 recipes</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-wine-bottle text-4xl text-purple-500 group-hover:text-purple-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Dessert</h3>
                            <p class="mt-1 text-gray-500 text-xs">298 recipes</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col text-center bg-gray-50 rounded-lg p-6 hover:shadow-md transition duration-300 group cursor-pointer">
                        <div class="flex-1 flex flex-col">
                            <i class="fas fa-seedling text-4xl text-teal-500 group-hover:text-teal-600 mx-auto mb-4"></i>
                            <h3 class="text-gray-900 text-sm font-medium">Vegan</h3>
                            <p class="mt-1 text-gray-500 text-xs">186 recipes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Recipes -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Community Favorites</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Top-rated recipes this week
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Recipe Card 1 -->
                <div class="recipe-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative">
                    <div class="h-48 overflow-hidden relative">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mnx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60" alt="Recipe image">
                        <div class="recipe-overlay absolute inset-0 bg-black bg-opacity-30 opacity-0 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-red-500 rounded-full p-3 hover:bg-red-500 hover:text-white transition duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Creamy Garlic Pasta</h3>
                                <p class="text-gray-600 text-sm">By Chef Maria</p>
                            </div>
                            <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                <span class="text-xs text-gray-700">25 min</span>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star-half-alt text-yellow-400"></i>
                                </div>
                                <span class="text-gray-500 text-sm ml-1">(243)</span>
                            </div>
                            <button class="text-red-500 hover:text-red-600">
                                <i class="far fa-heart text-lg"></i>
                            </button>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-users text-gray-400 text-sm mr-2"></i>
                                <span class="text-gray-500 text-xs">Serves 4</span>
                            </div>
                            <button class="bg-red-100 text-red-500 hover:bg-red-500 hover:text-white text-xs px-3 py-1 rounded-full transition duration-300">Beginner</button>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 2 -->
                <div class="recipe-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative">
                    <div class="h-48 overflow-hidden relative">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTd8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recipe image">
                        <div class="recipe-overlay absolute inset-0 bg-black bg-opacity-30 opacity-0 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-red-500 rounded-full p-3 hover:bg-red-500 hover:text-white transition duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">BBQ Ribs</h3>
                                <p class="text-gray-600 text-sm">By Chef Michael</p>
                            </div>
                            <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                <span class="text-xs text-gray-700">3 hrs</span>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <span class="text-gray-500 text-sm ml-1">(512)</span>
                            </div>
                            <button class="text-red-500 hover:text-red-600">
                                <i class="fas fa-heart text-lg"></i>
                            </button>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-users text-gray-400 text-sm mr-2"></i>
                                <span class="text-gray-500 text-xs">Serves 6</span>
                            </div>
                            <button class="bg-red-100 text-red-500 hover:bg-red-500 hover:text-white text-xs px-3 py-1 rounded-full transition duration-300">Advanced</button>
                        </div>
                    </div>
                </div>

                <!-- Recipe Card 3 -->
                <div class="recipe-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 relative">
                    <div class="h-48 overflow-hidden relative">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1481931098730-318b6f776db0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTB8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recipe image">
                        <div class="recipe-overlay absolute inset-0 bg-black bg-opacity-30 opacity-0 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-red-500 rounded-full p-3 hover:bg-red-500 hover:text-white transition duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Rainbow Salad Bowl</h3>
                                <p class="text-gray-600 text-sm">By Chef Emily</p>
                            </div>
                            <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                <span class="text-xs text-gray-700">15 min</span>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <span class="text-gray-500 text-sm ml-1">(194)</span>
                            </div>
                            <button class="text-red-500 hover:text-red-600">
                                <i class="far fa-heart text-lg"></i>
                            </button>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-users text-gray-400 text-sm mr-2"></i>
                                <span class="text-gray-500 text-xs">Serves 2</span>
                            </div>
                            <button class="bg-red-100 text-red-500 hover:bg-red-500 hover:text-white text-xs px-3 py-1 rounded-full transition duration-300">Easy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipe Submission -->
    <div id="submitRecipeSection" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Share Your Creation</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Submit your own recipe
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Join our community of food lovers and share your favorite recipes with step-by-step instructions and videos.
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl shadow-inner p-6">
                <div class="space-y-6">
                    <div>
                        <label for="recipe-name" class="block text-sm font-medium text-gray-700">Recipe Name</label>
                        <div class="mt-1">
                            <input type="text" id="recipe-name" name="recipe-name" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="3" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg"></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="prep-time" class="block text-sm font-medium text-gray-700">Prep Time (mins)</label>
                            <div class="mt-1">
                                <input type="number" id="prep-time" name="prep-time" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label for="cook-time" class="block text-sm font-medium text-gray-700">Cook Time (mins)</label>
                            <div class="mt-1">
                                <input type="number" id="cook-time" name="cook-time" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label for="servings" class="block text-sm font-medium text-gray-700">Servings</label>
                            <div class="mt-1">
                                <input type="number" id="servings" name="servings" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Difficulty Level</label>
                        <div class="mt-2 flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="difficulty" class="h-4 w-4 text-red-600 focus:ring-red-500" checked>
                                <span class="ml-2 text-sm text-gray-700">Beginner</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="difficulty" class="h-4 w-4 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-700">Intermediate</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="difficulty" class="h-4 w-4 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-700">Advanced</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Add Photo</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 10MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Add Video Tutorial (Optional)</label>
                        <div class="mt-1">
                            <input type="text" placeholder="Paste YouTube or Vimeo URL" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredients (one per line)</label>
                            <div class="mt-1">
                                <textarea id="ingredients" name="ingredients" rows="5" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg"></textarea>
                            </div>
                        </div>
                        <div>
                            <label for="instructions" class="block text-sm font-medium text-gray-700">Instructions (step by step)</label>
                            <div class="mt-1">
                                <textarea id="instructions" name="instructions" rows="5" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mr-3">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Submit Recipe
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Community Chat Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Ask the Community</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Get real-time cooking help
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Connect with fellow cooks in our live chat to get instant answers to your cooking questions.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="flex h-[500px]">
                    <!-- Sidebar with recent conversations -->
                    <div class="w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Recent Conversations</h3>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <div class="divide-y divide-gray-200">
                                <div class="p-4 hover:bg-gray-100 cursor-pointer">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/44.jpg" alt="User avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Chef Samantha</p>
                                            <p class="text-sm text-gray-500 truncate">Yes, you can substitute buttermilk with...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-100 cursor-pointer bg-gray-100">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Baker Mike</p>
                                            <p class="text-sm text-gray-500 truncate">For that perfect flaky crust, try...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 hover:bg-gray-100 cursor-pointer">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="User avatar">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Lisa P.</p>
                                            <p class="text-sm text-gray-500 truncate">Looking for gluten-free dessert ideas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main chat area -->
                    <div class="w-2/3 flex flex-col">
                        <!-- Chat header -->
                        <div class="p-4 border-b border-gray-200 flex items-center">
                            <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Baker Mike</p>
                                <p class="text-xs text-gray-500">Online now</p>
                            </div>
                            <div class="ml-auto flex space-x-2">
                                <button class="p-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100">
                                    <i class="fas fa-phone"></i>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100">
                                    <i class="fas fa-video"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Messages -->
                        <div id="chatMessages" class="flex-1 p-4 overflow-y-auto bg-gray-50 border-b border-gray-200">
                            <div class="space-y-4">
                                <!-- Received message -->
                                <div class="flex items-start">
                                    <img class="h-8 w-8 rounded-full object-cover mr-3" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                                    <div class="chat-message">
                                        <div class="bg-white p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                                            <p class="text-sm text-gray-800">For that perfect flaky crust, try chilling your butter and using a combination of butter and lard. The key is to keep everything cold!</p>
                                        </div>
                                        <span class="message-time hidden text-xs text-gray-500 mt-1">2:34 PM</span>
                                    </div>
                                </div>

                                <!-- Sent message -->
                                <div class="flex items-start justify-end">
                                    <div class="chat-message">
                                        <div class="bg-red-100 p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                                            <p class="text-sm text-gray-800">Thank you! How long should I refrigerate the dough before baking?</p>
                                        </div>
                                        <span class="message-time hidden text-xs text-gray-500 mt-1 text-right">2:37 PM</span>
                                    </div>
                                </div>

                                <!-- Received message with typing indicator -->
                                <div class="flex items-start">
                                    <img class="h-8 w-8 rounded-full object-cover mr-3" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                                    <div class="chat-message">
                                        <div class="bg-white p-3 rounded-lg shadow-sm max-w-xs lg:max-w-md">
                                            <div class="typing-indicator flex items-center">
                                                <div class="dot h-2 w-2 rounded-full bg-gray-400 mr-1 animate-bounce"></div>
                                                <div class="dot h-2 w-2 rounded-full bg-gray-400 mr-1 animate-bounce" style="animation-delay: 0.2s"></div>
                                                <div class="dot h-2 w-2 rounded-full bg-gray-400 animate-bounce" style="animation-delay: 0.4s"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message input -->
                        <div class="p-4 bg-white">
                            <div class="flex items-center">
                                <button class="p-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100 mr-2">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                <input type="text" placeholder="Type your message..." class="flex-1 py-2 px-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <button class="ml-2 p-2 text-white bg-red-500 rounded-full hover:bg-red-600">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Personalized Recommendations -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">For You</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Recipes you might like
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Based on your preferences and past cooking history
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Recommended Recipe 1 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden relative group">
                        <div class="h-48 overflow-hidden relative">
                            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTl8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recommended recipe">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
                                <i class="fas fa-bookmark text-red-500"></i>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Eggplant Parmesan</h3>
                                    <p class="text-gray-600 text-sm">By Chef Sophia</p>
                                </div>
                                <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                    <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                    <span class="text-xs text-gray-700">45 min</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600">Because you enjoyed Italian cuisine and vegetarian dishes last week</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Recipe 2 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden relative group">
                        <div class="h-48 overflow-hidden relative">
                            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MjJ8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recommended recipe">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
                                <i class="fas fa-bookmark text-red-500"></i>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Chocolate Dipped Strawberries</h3>
                                    <p class="text-gray-600 text-sm">By Chef Daniel</p>
                                </div>
                                <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                    <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                    <span class="text-xs text-gray-700">20 min</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600">Perfect dessert to pair with the wine you rated highly</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Recipe 3 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden relative group">
                        <div class="h-48 overflow-hidden relative">
                            <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1484723091739-30a097e8f929?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MjR8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recommended recipe">
                            <div class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
                                <i class="fas fa-bookmark text-red-500"></i>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Avocado Bruschetta</h3>
                                    <p class="text-gray-600 text-sm">By Chef Elena</p>
                                </div>
                                <div class="flex items-center bg-gray-100 px-2 py-1 rounded-full">
                                    <i class="fas fa-clock text-gray-500 text-xs mr-1"></i>
                                    <span class="text-xs text-gray-700">15 min</span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600">Quick appetizer to complement your frequent brunch parties</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating System -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Rate & Review</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Share your experience
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden max-w-3xl mx-auto">
                <div class="md:flex">
                    <div class="md:flex-shrink-0 p-6">
                        <img class="h-48 w-full object-cover md:w-48" src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTd8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Recipe to be rated">
                    </div>
                    <div class="p-8 flex-1">
                        <div class="flex items-center text-sm">
                            <h3 class="text-xl font-bold text-gray-900">BBQ Ribs</h3>
                            <span class="ml-2 text-gray-500">by Chef Michael</span>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Juicy, fall-off-the-bone ribs with homemade BBQ sauce</p>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-900">Rate this recipe</h4>
                            <div class="flex mt-1">
                                <button class="focus:outline-none text-yellow-400">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                                <button class="focus:outline-none text-yellow-400 ml-1">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                                <button class="focus:outline-none text-yellow-400 ml-1">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                                <button class="focus:outline-none text-yellow-400 ml-1">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                                <button class="focus:outline-none text-gray-300 ml-1">
                                    <i class="fas fa-star text-2xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="review" class="block text-sm font-medium text-gray-700">Write a review</label>
                            <div class="mt-1">
                                <textarea id="review" name="review" rows="3" class="py-3 px-4 block w-full shadow-sm focus:ring-red-500 focus:border-red-500 border-gray-300 rounded-lg" placeholder="What did you like or dislike about this recipe? Did you make any modifications?"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="photo-upload" class="block text-sm font-medium text-gray-700">Upload a photo of your result (optional)</label>
                            <div class="mt-1 flex items-center">
                                <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100 mr-2">
                                    <input type="file" id="photo-upload" class="sr-only">
                                    <label for="photo-upload" class="h-full w-full flex items-center justify-center cursor-pointer">
                                        <i class="fas fa-camera text-gray-400"></i>
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button class="w-full bg-red-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Submit Review
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/44.jpg" alt="User avatar">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Sarah K.</p>
                            <div class="flex items-center mt-1">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-500 ml-1">January 15, 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Absolute perfection! The ribs were fall-off-the-bone tender, and the sauce had just the right balance of sweet and spicy. I've made them three times now and they never disappoint. The only change I made was adding a bit more garlic to the rub.</p>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <img class="h-16 w-16 rounded object-cover" src="https://images.unsplash.com/photo-1567620835333-7e5d9c11d969?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MjN8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=300&q=60" alt="Review photo">
                        <img class="h-16 w-16 rounded object-cover" src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTd8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=300&q=60" alt="Review photo">
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User avatar">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">David T.</p>
                            <div class="flex items-center mt-1">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-gray-300 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-500 ml-1">December 30, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Great ribs overall! The flavor was excellent, and the cooking method worked perfectly. My only suggestion would be to reduce the amount of sugar in the sauce a bit as I found it a tad too sweet for my taste. I served them with coleslaw and cornbread - amazing combination!</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="User avatar">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Lisa P.</p>
                            <div class="flex items-center mt-1">
                                <div class="flex">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                                <span class="text-xs text-gray-500 ml-1">November 22, 2022</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Made these for our family reunion and they were a HUGE hit! I doubled the recipe and prepped everything the day before. Wrapped them in foil with the rub and let them sit overnight in the fridge. The next day I just popped them in the oven as directed. Everyone raved about them - even my "expert" BBQ brother-in-law asked for the recipe!</p>
                    </div>
                    <div class="mt-4">
                        <img class="h-16 w-16 rounded object-cover" src="https://images.unsplash.com/photo-1565299624943-b4f52b79df85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8OHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=60" alt="Review photo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Tutorial Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-red-500 font-semibold tracking-wide uppercase">Learn & Improve</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Video Tutorials
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Watch our carefully curated cooking tutorials from expert chefs
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 relative group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1563281577-a7be47e20db9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NDR8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Video thumbnail">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-100 group-hover:opacity-70 transition-opacity duration-300">
                            <div class="bg-white text-red-500 rounded-full p-3 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                            12:34
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900">Knife Skills: Mastering the Basics</h3>
                        <div class="mt-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/41.jpg" alt="Chef avatar">
                                <span class="ml-2 text-sm text-gray-600">Chef Robert</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-400 text-xs mr-1"></i>
                                <span class="text-xs text-gray-500">12.5K views</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 relative group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1557844352-7619dce8255c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NDZ8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Video thumbnail">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-100 group-hover:opacity-70 transition-opacity duration-300">
                            <div class="bg-white text-red-500 rounded-full p-3 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                            8:21
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900">Perfect Egg Techniques</h3>
                        <div class="mt-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/63.jpg" alt="Chef avatar">
                                <span class="ml-2 text-sm text-gray-600">Chef Sophia</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-400 text-xs mr-1"></i>
                                <span class="text-xs text-gray-500">8.7K views</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 relative group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/embed/dQw4w9WgXcQ')">
                        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1519822472072-ec86d5ab8abb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NTV8fHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=500&q=60" alt="Video thumbnail">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-100 group-hover:opacity-70 transition-opacity duration-300">
                            <div class="bg-white text-red-500 rounded-full p-3 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-lg"></i>
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                            16:12
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900">Artisan Bread Making</h3>
                        <div class="mt-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/86.jpg" alt="Chef avatar">
                                <span class="ml-2 text-sm text-gray-600">Baker Mike</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-eye text-gray-400 text-xs mr-1"></i>
                                <span class="text-xs text-gray-500">15.2K views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <button class="bg-red-600 border border-transparent rounded-md shadow-sm py-3 px-6 inline-flex items-center text-lg font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-video mr-2"></i> View All Tutorials
                </button>
            </div>
        </div>
    </div>

    <!-- Video Modal (hidden by default) -->
    <div id="videoModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start flex-col items-center">
                        <button id="closeModal" class="ml-auto mb-2 text-gray-500 hover:text-red-500 text-2xl font-bold focus:outline-none" aria-label="Close">&times;</button>
                        <div class="w-full aspect-w-16 aspect-h-9">
                            <iframe id="videoFrame" class="w-full h-72" src="" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login/Sign Up Modal -->
    <div id="authModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
      <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md z-10 p-8 relative">
          <button id="closeAuthModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold focus:outline-none" aria-label="Close">&times;</button>
          <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Log In / Sign Up</h2>
          <form id="authForm" class="space-y-4">
            <div>
              <label for="authEmail" class="block text-sm font-medium text-gray-700">Email</label>
              <input id="authEmail" type="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
              <label for="authPassword" class="block text-sm font-medium text-gray-700">Password</label>
              <input id="authPassword" type="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
              <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md font-medium hover:bg-red-700 transition">Log In</button>
            </div>
            <div class="text-center text-sm text-gray-500">
              Don't have an account?
              <a href="#" id="toggleLogin" class="text-red-600 hover:underline">Sign Up</a>
            </div>
          </form>
          <form id="signupForm" class="space-y-4 hidden">
            <div>
              <label for="signupUsername" class="block text-sm font-medium text-gray-700">Username</label>
              <input id="signupUsername" type="text" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
              <label for="signupEmail" class="block text-sm font-medium text-gray-700">Email</label>
              <input id="signupEmail" type="email" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
              <label for="signupPassword" class="block text-sm font-medium text-gray-700">Password</label>
              <input id="signupPassword" type="password" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
            </div>
            <div>
              <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-md font-medium hover:bg-red-700 transition">Sign Up</button>
            </div>
            <div class="text-center text-sm text-gray-500">
              Already have an account?
              <a href="#" id="toggleSignup" class="text-red-600 hover:underline">Log In</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Recipes</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Browse All</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Categories</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Trending</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">What's New</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Community</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Forums</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Live Chat</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Events</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Chefs</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">About</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Team</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Careers</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Connect</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Instagram</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Facebook</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Twitter</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">YouTube</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-gray-400 text-center">&copy; 2023 CookConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Include app.js for all functionality -->
    <script src="app.js"></script>

    <script>
        document.getElementById('authForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const email = document.getElementById('authEmail').value;
            const password = document.getElementById('authPassword').value;

            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('email', email);
            formData.append('password', password);

            const response = await fetch('process.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                location.reload(); // or redirect to another page if needed
            } else {
                alert(result.message);
            }
        });
    </script>

</body>
</html>
