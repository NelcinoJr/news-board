<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G1 - O seu portal de notícias</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Vue 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">
    
    <div id="app">
        <!-- Barra superior -->
        <div class="bg-red-700 text-white py-3">
            <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="text-3xl font-extrabold tracking-tighter">g1</a>
                <div class="flex space-x-6 text-sm font-semibold">
                    <a href="/" class="hover:underline">Últimas Notícias</a>
                    <a href="/admin" class="hover:underline text-red-200">Painel Admin</a>
                </div>
            </div>
        </div>

        <!-- Menu de Categorias -->
        <div class="bg-red-600 text-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 flex space-x-6 overflow-x-auto py-3 text-sm font-bold uppercase tracking-wider">
                <button @click="searchQuery = ''; fetchNews()" class="hover:text-red-200 transition whitespace-nowrap">Todas</button>
                <button v-for="cat in categories" :key="cat.id" @click="searchQuery = cat.name; fetchNews()" class="hover:text-red-200 transition whitespace-nowrap">
                    @{{ cat.name }}
                </button>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 py-8">
            <!-- Destaque -->
            <div v-if="news.length > 0" class="mb-12">
                <article class="relative group cursor-pointer rounded-xl overflow-hidden shadow-lg h-[500px]">
                    <img v-if="news[0].image" :src="news[0].image" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    <div v-else class="absolute inset-0 w-full h-full bg-gray-800 flex justify-center items-center">
                        <svg class="w-24 h-24 text-gray-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-8">
                        <span class="text-red-500 font-bold text-sm uppercase tracking-wider mb-2 block">@{{ news[0].category?.name }}</span>
                        <h2 class="text-white text-4xl font-bold leading-tight mb-3 group-hover:underline">@{{ news[0].title }}</h2>
                        <p class="text-gray-300 text-lg line-clamp-2">@{{ news[0].content }}</p>
                    </div>
                </article>
            </div>

            <div v-if="isLoading" class="text-center py-20">Carregando...</div>

            <!-- Outras Notícias -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <article v-for="item in news.slice(1)" :key="item.id" class="group cursor-pointer">
                    <div class="h-48 rounded-lg overflow-hidden mb-3 bg-gray-200">
                        <img v-if="item.image" :src="item.image" class="w-full h-full object-cover group-hover:opacity-90 transition">
                    </div>
                    <span class="text-red-600 font-bold text-xs uppercase mb-1 block">@{{ item.category?.name }}</span>
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-700 transition leading-snug mb-2">@{{ item.title }}</h3>
                    <p class="text-gray-600 text-sm line-clamp-3">@{{ item.content }}</p>
                    <div class="mt-2 text-xs text-gray-400">@{{ new Date(item.created_at).toLocaleDateString('pt-BR') }}</div>
                </article>
            </div>
        </div>
    </div>

    <script>
        const { createApp, ref, onMounted } = Vue;

        createApp({
            setup() {
                const news = ref([]);
                const categories = ref([]);
                const searchQuery = ref('');
                const isLoading = ref(true);

                const fetchCategories = async () => {
                    const response = await axios.get('/api/categories');
                    categories.value = response.data;
                };

                const fetchNews = async () => {
                    isLoading.value = true;
                    try {
                        const response = await axios.get('/api/news', {
                            params: { search: searchQuery.value }
                        });
                        news.value = response.data;
                    } finally {
                        isLoading.value = false;
                    }
                };

                onMounted(() => {
                    fetchCategories();
                    fetchNews();
                });

                return {
                    news,
                    categories,
                    searchQuery,
                    isLoading,
                    fetchNews
                }
            }
        }).mount('#app')
    </script>
</body>
</html>