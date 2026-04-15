<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Board Premium</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Vue 3 -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-blue-50 min-h-screen text-gray-800 antialiased">
    
    <div id="app" class="max-w-6xl mx-auto p-4 sm:p-8">
        <!-- Header -->
        <header class="mb-12 text-center pt-8">
            <div class="inline-block p-3 bg-indigo-100 rounded-2xl mb-4 text-indigo-600 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 mb-3">Painel <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Admin</span></h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto mb-4">Gerencie as publicações e categorias do portal.</p>
            <a href="/" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Acessar Portal Público (G1 Style)
            </a>
        </header>

        <!-- Search Bar -->
        <div class="mb-10 max-w-3xl mx-auto relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input 
                v-model="searchQuery" 
                @input="fetchNews"
                type="text" 
                placeholder="Pesquisar por título ou categoria..." 
                class="w-full pl-12 pr-4 py-4 bg-white border border-gray-200 rounded-2xl shadow-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-lg"
            >
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar (Forms) -->
            <div class="w-full lg:w-1/3 space-y-8">
                
                <!-- Nova Notícia -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl shadow-xl shadow-indigo-100/50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Nova Notícia</h2>
                    </div>
                    
                    <form @submit.prevent="saveNews" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Título da Notícia</label>
                            <input v-model="form.title" type="text" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Categoria</label>
                            <select v-model="form.category_id" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer">
                                <option value="" disabled>Selecione uma categoria...</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">@{{ cat.name }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Imagem de Capa (Opcional)</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl px-4 py-6 hover:border-indigo-500 transition-colors bg-gray-50/30 text-center cursor-pointer overflow-hidden" @click="$refs.fileInput.click()">
                                <div v-if="!imagePreview">
                                    <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    <p class="mt-2 text-sm text-gray-500">Clique para selecionar imagem</p>
                                </div>
                                <div v-else class="relative z-10">
                                    <img :src="imagePreview" class="max-h-32 mx-auto rounded-lg object-cover shadow-sm">
                                    <p class="mt-2 text-xs text-indigo-600 font-medium">Imagem selecionada (clique para trocar)</p>
                                </div>
                                <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="handleImageUpload">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Conteúdo</label>
                            <textarea v-model="form.content" required rows="5" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" :disabled="isSubmitting" class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold px-6 py-4 rounded-xl hover:from-indigo-700 hover:to-blue-700 focus:ring-4 focus:ring-indigo-300 transition-all transform active:scale-95 flex justify-center items-center gap-2">
                            <span v-if="isSubmitting"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Publicando...</span>
                            <span v-else>Publicar Notícia</span>
                        </button>
                    </form>
                </div>

                <!-- Nova Categoria -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl shadow-xl shadow-indigo-100/50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Criar Categoria
                    </h3>
                    <form @submit.prevent="saveCategory" class="flex gap-3">
                        <input v-model="newCategory" type="text" placeholder="Ex: Mercado Financeiro" required class="flex-1 px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                        <button type="submit" class="bg-gray-800 text-white font-bold px-5 py-3 rounded-xl hover:bg-gray-900 transition-colors shadow-md">
                            Add
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lista de Notícias -->
            <div class="w-full lg:w-2/3">
                
                <div v-if="isLoading" class="flex justify-center items-center py-20">
                    <svg class="animate-spin h-10 w-10 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>

                <div v-else-if="news.length === 0" class="glass-panel text-center py-24 rounded-3xl">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700">Nenhuma notícia encontrada</h3>
                    <p class="text-gray-500 mt-2">Tente buscar por outro termo ou crie uma nova publicação.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <article v-for="item in news" :key="item.id" class="bg-white rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group">
                        
                        <!-- Capa da Notícia -->
                        <div class="h-48 w-full bg-gray-100 relative overflow-hidden">
                            <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-100 to-blue-50">
                                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <!-- Tag de Categoria -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/90 backdrop-blur text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    @{{ item.category?.name }}
                                </span>
                            </div>
                        </div>

                        <!-- Conteúdo da Notícia -->
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-indigo-600 transition-colors">@{{ item.title }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-1">@{{ item.content }}</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-auto">
                                <div class="flex items-center text-xs text-gray-500 font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    @{{ new Date(item.created_at).toLocaleDateString('pt-BR') }}
                                </div>
                                <button @click="deleteNews(item.id)" class="text-red-500 hover:text-red-700 text-sm font-semibold flex items-center transition-colors px-3 py-1 bg-red-50 hover:bg-red-100 rounded-lg">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Excluir
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification (Simples) -->
    <div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 z-50">
        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span id="toast-msg" class="font-medium">Sucesso!</span>
    </div>

    <script>
        const { createApp, ref, onMounted } = Vue;
        
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        createApp({
            setup() {
                const news = ref([]);
                const categories = ref([]);
                const searchQuery = ref('');
                const newCategory = ref('');
                const isLoading = ref(true);
                const isSubmitting = ref(false);
                const imageFile = ref(null);
                const imagePreview = ref(null);
                const fileInput = ref(null);
                
                const form = ref({
                    title: '',
                    content: '',
                    category_id: ''
                });

                const showToast = (msg, type = 'success') => {
                    const toast = document.getElementById('toast');
                    const toastMsg = document.getElementById('toast-msg');
                    toastMsg.innerText = msg;
                    toast.classList.remove('translate-y-20', 'opacity-0');
                    setTimeout(() => toast.classList.add('translate-y-20', 'opacity-0'), 3000);
                };

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

                const saveCategory = async () => {
                    try {
                        await axios.post('/api/categories', { name: newCategory.value });
                        newCategory.value = '';
                        await fetchCategories();
                        showToast('Categoria criada com sucesso!');
                    } catch (error) {
                        alert(error.response?.data?.message || 'Erro ao criar categoria.');
                    }
                };

                const handleImageUpload = (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        imageFile.value = file;
                        imagePreview.value = URL.createObjectURL(file);
                    }
                };

                const saveNews = async () => {
                    isSubmitting.value = true;
                    try {
                        // Usando FormData por causa da imagem
                        const formData = new FormData();
                        formData.append('title', form.value.title);
                        formData.append('content', form.value.content);
                        formData.append('category_id', form.value.category_id);
                        if (imageFile.value) {
                            formData.append('image', imageFile.value);
                        }

                        await axios.post('/api/news', formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        });
                        
                        form.value = { title: '', content: '', category_id: '' };
                        imageFile.value = null;
                        imagePreview.value = null;
                        if(fileInput.value) fileInput.value.value = '';
                        
                        await fetchNews();
                        showToast('Notícia publicada com sucesso!');
                    } catch (error) {
                        alert(error.response?.data?.message || 'Erro ao publicar notícia.');
                    } finally {
                        isSubmitting.value = false;
                    }
                };

                const deleteNews = async (id) => {
                    if(!confirm('Tem certeza que deseja excluir esta notícia?')) return;
                    try {
                        await axios.delete(`/api/news/${id}`);
                        showToast('Notícia excluída com sucesso!', 'success');
                        await fetchNews();
                    } catch (error) {
                        alert('Erro ao excluir a notícia.');
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
                    isLoading,
                    isSubmitting,
                    imagePreview,
                    fileInput,
                    fetchNews,
                    saveCategory,
                    saveNews,
                    deleteNews,
                    handleImageUpload
                }
            }
        }).mount('#app')
    </script>
</body>
</html>
