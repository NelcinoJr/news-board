<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Investidor10</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Vue 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        h1, h2, h3, .brand { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    
    <div id="app">
        <!-- Barra superior -->
        <div class="bg-emerald-800 text-white py-4 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <a href="/" class="text-3xl font-extrabold tracking-tight brand flex items-center gap-2">
                    <svg class="w-8 h-8 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path></svg>
                    Investidor10
                </a>
            </div>
        </div>

        <!-- Menu de Categorias -->
        <div class="bg-emerald-700 text-emerald-50 border-t border-emerald-600">
            <div class="max-w-7xl mx-auto px-4 flex space-x-6 overflow-x-auto py-3 text-sm font-bold uppercase tracking-wider">
                <button @click="searchQuery = ''; fetchNews()" class="hover:text-white transition whitespace-nowrap" :class="{'text-emerald-300': searchQuery === ''}">TODAS AS NOTÍCIAS</button>
                <button v-for="cat in categories" :key="cat.id" @click="searchQuery = cat.name; fetchNews()" class="hover:text-white transition whitespace-nowrap" :class="{'text-emerald-300': searchQuery === cat.name}">
                    @{{ cat.name }}
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            
            <!-- Visão Detalhada da Notícia (Single Page) -->
            <div v-if="selectedNews" class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in pb-12">
                <div class="relative h-[400px] md:h-[500px] w-full">
                    <img v-if="selectedNews.image" :src="selectedNews.image" class="w-full h-full object-cover">
                    <div v-else class="w-full h-full bg-slate-800 flex justify-center items-center">
                        <svg class="w-32 h-32 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                    <button @click="selectedNews = null" class="absolute top-6 left-6 bg-white/20 hover:bg-white/40 backdrop-blur-md text-white px-4 py-2 rounded-full flex items-center gap-2 transition font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar para Notícias
                    </button>
                </div>
                <div class="max-w-4xl mx-auto px-6 md:px-12 -mt-20 relative z-10">
                    <span class="bg-emerald-600 text-white font-bold text-xs uppercase tracking-wider px-3 py-1 rounded-sm mb-4 inline-block shadow-md">@{{ selectedNews.category?.name }}</span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight drop-shadow-md">@{{ selectedNews.title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-slate-500 font-medium mb-10 pb-6 border-b border-slate-100 bg-white p-6 rounded-xl shadow-sm">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> @{{ new Date(selectedNews.created_at).toLocaleDateString('pt-BR') }}</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 5 min de leitura</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Redação Investidor10</span>
                    </div>
                    <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed whitespace-pre-line bg-white px-6 md:px-0">
                        @{{ selectedNews.content }}
                    </div>
                </div>
            </div>

            <!-- Lista de Notícias (Mostrada apenas quando não houver notícia selecionada) -->
            <div v-else>
                <!-- Destaque -->
                <div v-if="news.length > 0" class="mb-12">
                    <article @click="selectedNews = news[0]; window.scrollTo(0,0)" class="relative group cursor-pointer rounded-2xl overflow-hidden shadow-2xl h-[550px]">
                    <img v-if="news[0].image" :src="news[0].image" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-1000 ease-in-out">
                    <div v-else class="absolute inset-0 w-full h-full bg-slate-800 flex justify-center items-center">
                        <svg class="w-32 h-32 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-10 w-full md:w-3/4">
                        <span class="bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider px-3 py-1 rounded-full mb-4 inline-block">@{{ news[0].category?.name }}</span>
                        <h2 class="text-white text-5xl font-extrabold leading-tight mb-4 group-hover:text-emerald-300 transition">@{{ news[0].title }}</h2>
                        <p class="text-slate-300 text-lg line-clamp-2">@{{ news[0].content }}</p>
                    </div>
                </article>
            </div>

            <div v-if="isLoading" class="flex justify-center py-20">
                <svg class="animate-spin h-10 w-10 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>

                <!-- Outras Notícias -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article @click="selectedNews = item; window.scrollTo(0,0)" v-for="item in news.slice(1)" :key="item.id" class="group cursor-pointer bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
                        <div class="h-56 overflow-hidden bg-slate-100 relative">
                        <img v-if="item.image" :src="item.image" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 left-4">
                            <span class="bg-slate-900/80 backdrop-blur text-white font-bold text-xs uppercase tracking-wider px-3 py-1 rounded-sm">@{{ item.category?.name }}</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <h3 class="text-2xl font-bold text-slate-800 group-hover:text-emerald-700 transition leading-snug mb-3">@{{ item.title }}</h3>
                        <p class="text-slate-600 text-sm line-clamp-3 mb-4 flex-1">@{{ item.content }}</p>
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-slate-400 uppercase tracking-wide">
                            <span>MERCADO</span>
                            <span>@{{ new Date(item.created_at).toLocaleDateString('pt-BR') }}</span>
                        </div>
                    </div>
                    </article>
                </div>
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
                const selectedNews = ref(null);

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
                    selectedNews,
                    fetchNews
                }
            }
        }).mount('#app')
    </script>
</body>
</html>