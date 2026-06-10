<header class="glass-header flex items-center justify-between px-6 py-4">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        <div class="relative mx-4 lg:mx-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>

            <input class="w-32 pl-10 pr-4 rounded-md form-input sm:w-64 focus:border-indigo-600" type="text"
                placeholder="Search">
        </div>
    </div>

    <div class="flex items-center">
        <div x-data="{ notificationOpen: false }" class="relative">
            <button @click="notificationOpen = ! notificationOpen" class="flex mx-4 text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div x-cloak x-show="notificationOpen" @click="notificationOpen = false"
                class="fixed inset-0 z-10 w-full h-full"></div>

            <div x-cloak x-show="notificationOpen"
                class="absolute right-0 z-10 mt-2 overflow-hidden bg-white rounded-lg shadow-xl w-80"
                style="width:20rem;">
                <!--
                <a href="#" class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar">
                    <p class="mx-2 text-sm">
                        <span class="font-bold" href="#">Sara Salah</span> replied on the <span class="font-bold text-indigo-400" href="#">Upload Image</span> artical . 2m
                    </p>
                </a>
                <a href="#" class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="avatar">
                    <p class="mx-2 text-sm">
                        <span class="font-bold" href="#">Slick Net</span> start following you . 45m
                    </p>
                </a>
                <a href="#" class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                    <img class="object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar">
                    <p class="mx-2 text-sm">
                        <span class="font-bold" href="#">Jane Doe</span> Like Your reply on <span class="font-bold text-indigo-400" href="#">Test with TDD</span> artical . 1h
                    </p>
                </a>
                -->
                <a href="#"
                    class="flex items-center px-4 py-3 -mx-2 text-gray-600 hover:text-white hover:bg-indigo-600">
                    <svg width="32" height="32" viewBox="0 0 64 64">
                        <path fill="#94989b"
                            d="m20.9 50.9l30-30c3.5.8 7.3-.1 10-2.8c2.7-2.7 3.6-6.5 2.8-10L55 16.7l-6.1-1.6L47.3 9L56 .3c-3.5-.8-7.3.1-10 2.8c-2.7 2.7-3.6 6.5-2.8 10l-30 30c-3.5-.8-7.3.1-10 2.8C-1 50-1 56.8 3.1 60.9c4.1 4.1 10.9 4.1 15 0c2.7-2.7 3.6-6.5 2.8-10m-8.7 8.6l-6.1-1.6l-1.6-6.1L9 47.3l6.1 1.6l1.6 6.1l-4.5 4.5" />
                        <path fill="#3e4347" d="m28.8 21.9l-5.6 5.8l-5.5-5.7l5.5-5.8z" />
                        <path fill="#94989b"
                            d="M16.7 5.1L6.9 15.2c-.4.4-.4 1 0 1.3l3.7 3.8l3.7 3.8c.4.4.9.4 1.3 0L25.4 14c.4-.4.4-1 0-1.3L18 5.1c-.3-.4-.9-.4-1.3 0M.3 22c-.4.4-.4 1 0 1.3L7.6 31c.4.4.9.4 1.3 0c0 0 2-2.1 2.1-2.2l-8.6-8.9C2.3 19.9.3 22 .3 22" />
                        <path fill="#3e4347"
                            d="m10.5 20.4l-3.7-3.8s1.2 2.1-2 2.5c-1.3.2-2.1.4-2.5.8l8.6 8.9c.4-.5.6-1.3.8-2.6c.4-3.3 2.4-2 2.4-2l-3.6-3.8M39.6 4.3C29.5-6 18.4 5.5 18.4 5.5l6.5 6.7s6.3-8.5 14.2-6.1c.9.3 1.7.7 2 .5c.4-.3-.8-1.6-1.5-2.3" />
                        <path fill="#f2b200"
                            d="m26 24.8l-3.6 3.7s1.9 3 5.1 6.3c3.5 3.6 8.2 5.7 12.9 10.5c7 7.2 12.8 15 14.9 17.9c.8 1.1.9 1 1.9 0l3-3.1L26 24.8" />
                        <path fill="#ffce31"
                            d="m26 24.8l3.6-3.7s2.9 1.9 6.1 5.2c3.5 3.6 5.5 8.5 10.2 13.3c7 7.2 14.5 13.2 17.4 15.4c1.1.8 1 1 0 2l-3 3.1L26 24.8" />
                    </svg>
                    <p class="mx-2 text-sm">
                        <span class="font-bold" href="#">Cette fonctionnalité est actuellement en cours de
                            développement</span>
                    </p>
                </a>
            </div>
        </div>

        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53 53"
                    style="enable-background:new 0 0 53 53;" xml:space="preserve">
                    <path style="fill:#E7ECED;" d="M18.613,41.552l-7.907,4.313c-0.464,0.253-0.881,0.564-1.269,0.903C14.047,50.655,19.998,53,26.5,53
 c6.454,0,12.367-2.31,16.964-6.144c-0.424-0.358-0.884-0.68-1.394-0.934l-8.467-4.233c-1.094-0.547-1.785-1.665-1.785-2.888v-3.322
 c0.238-0.271,0.51-0.619,0.801-1.03c1.154-1.63,2.027-3.423,2.632-5.304c1.086-0.335,1.886-1.338,1.886-2.53v-3.546
 c0-0.78-0.347-1.477-0.886-1.965v-5.126c0,0,1.053-7.977-9.75-7.977s-9.75,7.977-9.75,7.977v5.126
 c-0.54,0.488-0.886,1.185-0.886,1.965v3.546c0,0.934,0.491,1.756,1.226,2.231c0.886,3.857,3.206,6.633,3.206,6.633v3.24
 C20.296,39.899,19.65,40.986,18.613,41.552z" />
                    <g>
                        <path class="w-12 fill-indigo-600" d="M26.953,0.004C12.32-0.246,0.254,11.414,0.004,26.047C-0.138,34.344,3.56,41.801,9.448,46.76
  c0.385-0.336,0.798-0.644,1.257-0.894l7.907-4.313c1.037-0.566,1.683-1.653,1.683-2.835v-3.24c0,0-2.321-2.776-3.206-6.633
  c-0.734-0.475-1.226-1.296-1.226-2.231v-3.546c0-0.78,0.347-1.477,0.886-1.965v-5.126c0,0-1.053-7.977,9.75-7.977
  s9.75,7.977,9.75,7.977v5.126c0.54,0.488,0.886,1.185,0.886,1.965v3.546c0,1.192-0.8,2.195-1.886,2.53
  c-0.605,1.881-1.478,3.674-2.632,5.304c-0.291,0.411-0.563,0.759-0.801,1.03V38.8c0,1.223,0.691,2.342,1.785,2.888l8.467,4.233
  c0.508,0.254,0.967,0.575,1.39,0.932c5.71-4.762,9.399-11.882,9.536-19.9C53.246,12.32,41.587,0.254,26.953,0.004z" />
                </svg>

            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full">
            </div>

            <div x-cloak x-show="dropdownOpen"
                class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white shadow-xl rounded-md">
                <a href="#"
                    class="flex px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"><svg
                        class="w-4 mr-8" viewBox="0 0 64 64">
                        <path fill="#94989b"
                            d="m20.9 50.9l30-30c3.5.8 7.3-.1 10-2.8c2.7-2.7 3.6-6.5 2.8-10L55 16.7l-6.1-1.6L47.3 9L56 .3c-3.5-.8-7.3.1-10 2.8c-2.7 2.7-3.6 6.5-2.8 10l-30 30c-3.5-.8-7.3.1-10 2.8C-1 50-1 56.8 3.1 60.9c4.1 4.1 10.9 4.1 15 0c2.7-2.7 3.6-6.5 2.8-10m-8.7 8.6l-6.1-1.6l-1.6-6.1L9 47.3l6.1 1.6l1.6 6.1l-4.5 4.5" />
                        <path fill="#3e4347" d="m28.8 21.9l-5.6 5.8l-5.5-5.7l5.5-5.8z" />
                        <path fill="#94989b"
                            d="M16.7 5.1L6.9 15.2c-.4.4-.4 1 0 1.3l3.7 3.8l3.7 3.8c.4.4.9.4 1.3 0L25.4 14c.4-.4.4-1 0-1.3L18 5.1c-.3-.4-.9-.4-1.3 0M.3 22c-.4.4-.4 1 0 1.3L7.6 31c.4.4.9.4 1.3 0c0 0 2-2.1 2.1-2.2l-8.6-8.9C2.3 19.9.3 22 .3 22" />
                        <path fill="#3e4347"
                            d="m10.5 20.4l-3.7-3.8s1.2 2.1-2 2.5c-1.3.2-2.1.4-2.5.8l8.6 8.9c.4-.5.6-1.3.8-2.6c.4-3.3 2.4-2 2.4-2l-3.6-3.8M39.6 4.3C29.5-6 18.4 5.5 18.4 5.5l6.5 6.7s6.3-8.5 14.2-6.1c.9.3 1.7.7 2 .5c.4-.3-.8-1.6-1.5-2.3" />
                        <path fill="#f2b200"
                            d="m26 24.8l-3.6 3.7s1.9 3 5.1 6.3c3.5 3.6 8.2 5.7 12.9 10.5c7 7.2 12.8 15 14.9 17.9c.8 1.1.9 1 1.9 0l3-3.1L26 24.8" />
                        <path fill="#ffce31"
                            d="m26 24.8l3.6-3.7s2.9 1.9 6.1 5.2c3.5 3.6 5.5 8.5 10.2 13.3c7 7.2 14.5 13.2 17.4 15.4c1.1.8 1 1 0 2l-3 3.1L26 24.8" />
                    </svg>Profile</a>
                <a href="#"
                    class="flex px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"><svg
                        class="w-4 mr-8" viewBox="0 0 64 64">
                        <path fill="#94989b"
                            d="m20.9 50.9l30-30c3.5.8 7.3-.1 10-2.8c2.7-2.7 3.6-6.5 2.8-10L55 16.7l-6.1-1.6L47.3 9L56 .3c-3.5-.8-7.3.1-10 2.8c-2.7 2.7-3.6 6.5-2.8 10l-30 30c-3.5-.8-7.3.1-10 2.8C-1 50-1 56.8 3.1 60.9c4.1 4.1 10.9 4.1 15 0c2.7-2.7 3.6-6.5 2.8-10m-8.7 8.6l-6.1-1.6l-1.6-6.1L9 47.3l6.1 1.6l1.6 6.1l-4.5 4.5" />
                        <path fill="#3e4347" d="m28.8 21.9l-5.6 5.8l-5.5-5.7l5.5-5.8z" />
                        <path fill="#94989b"
                            d="M16.7 5.1L6.9 15.2c-.4.4-.4 1 0 1.3l3.7 3.8l3.7 3.8c.4.4.9.4 1.3 0L25.4 14c.4-.4.4-1 0-1.3L18 5.1c-.3-.4-.9-.4-1.3 0M.3 22c-.4.4-.4 1 0 1.3L7.6 31c.4.4.9.4 1.3 0c0 0 2-2.1 2.1-2.2l-8.6-8.9C2.3 19.9.3 22 .3 22" />
                        <path fill="#3e4347"
                            d="m10.5 20.4l-3.7-3.8s1.2 2.1-2 2.5c-1.3.2-2.1.4-2.5.8l8.6 8.9c.4-.5.6-1.3.8-2.6c.4-3.3 2.4-2 2.4-2l-3.6-3.8M39.6 4.3C29.5-6 18.4 5.5 18.4 5.5l6.5 6.7s6.3-8.5 14.2-6.1c.9.3 1.7.7 2 .5c.4-.3-.8-1.6-1.5-2.3" />
                        <path fill="#f2b200"
                            d="m26 24.8l-3.6 3.7s1.9 3 5.1 6.3c3.5 3.6 8.2 5.7 12.9 10.5c7 7.2 12.8 15 14.9 17.9c.8 1.1.9 1 1.9 0l3-3.1L26 24.8" />
                        <path fill="#ffce31"
                            d="m26 24.8l3.6-3.7s2.9 1.9 6.1 5.2c3.5 3.6 5.5 8.5 10.2 13.3c7 7.2 14.5 13.2 17.4 15.4c1.1.8 1 1 0 2l-3 3.1L26 24.8" />
                    </svg>Paramètres</a>
                <form action="{{ route('p_logout') }}" method="post">
                    @csrf
                    <input class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white"
                        type="submit" value="Se déconnecter">
                </form>
            </div>
        </div>
    </div>
</header>
