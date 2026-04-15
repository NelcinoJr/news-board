<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Board</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Vue 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
    <div id="app" class="max-w-4xl mx-auto p-6">
        <!-- Header -->
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-blue-600 mb-2">📰 News Board</h1>
            <p class="text-gray-500">Sistema elegante de cadastro e busca de notícias</p>
        </header>

        <!-- Search Bar -->
        <div class="mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex gap-4">
            <input 
                v-model="searchQuery" 
                @keyup.enter="fetchNews"
                type="text" 
                placeholder="Buscar notícias por título ou categoria..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <button @click="fetchNews" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Buscar
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Formulário de Cadastro -->
            <div class="md:col-span-1 bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-fit">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Nova Notícia</h2>
                
                <form @submit.prevent="saveNews" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input v-model="form.title" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Conteúdo</label>
                        <textarea v-model="form.content" required rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select v-model="form.category_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecione...</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition font-medium">
                        Salvar Notícia
                    </button>
                </form>

                <hr class="my-6">
                
                <form @submit.prevent="saveCategory" class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-600">Adicionar Categoria</h3>
                    <div class="flex gap-2">
                        <input v-model="newCategory" type="text" placeholder="Nome" required class="flex-1 px-3 py-1 border border-gray-300 rounded-md text-sm">
                        <button type="submit" class="bg-gray-800 text-white px-3 py-1 rounded-md text-sm hover:bg-gray-900">+</button>
                    </div>
                </form>
            </div>

            <!-- Lista de Notícias -->
            <div class="md:col-span-2 space-y-4">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Últimas Notícias</h2>
                
                <div v-if="news.length === 0" class="text-center py-10 bg-white rounded-lg border border-gray-100">
                    <p class="text-gray-500">Nenhuma notícia encontrada.</p>
                </div>

                <article v-for="item in news" :key="item.id" class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-900">{{ item.title }}</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                            {{ item.category?.name }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm whitespace-pre-line">{{ item.content }}</p>
                    <div class="mt-4 text-xs text-gray-400">
                        Publicado em: {{ new Date(item.created_at).toLocaleDateString('pt-BR') }}
                    </div>
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
                const newCategory = ref('');
                
                const form = ref({
                    title: '',
                    content: '',
                    category_id: ''
                });

                const fetchCategories = async () => {
                    const response = await axios.get('/api/categories');
                    categories.value = response.data;
                };

                const fetchNews = async () => {
                    const response = await axios.get('/api/news', {
                        params: { search: searchQuery.value }
                    });
                    news.value = response.data;
                };

                const saveCategory = async () => {
                    try {
                        await axios.post('/api/categories', { name: newCategory.value });
                        newCategory.value = '';
                        await fetchCategories();
                        alert('Categoria criada com sucesso!');
                    } catch (error) {
                        alert('Erro ao criar categoria.');
                    }
                };

                const saveNews = async () => {
                    try {
                        await axios.post('/api/news', form.value);
                        form.value = { title: '', content: '', category_id: '' };
                        await fetchNews();
                        alert('Notícia criada com sucesso!');
                    } catch (error) {
                        alert('Erro ao criar notícia.');
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
                    newCategory,
                    form,
                    fetchNews,
                    saveCategory,
                    saveNews
                }
            }
        }).mount('#app')
    </script>
</body>
</html>
