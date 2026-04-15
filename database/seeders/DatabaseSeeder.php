<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpar dados anteriores
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        News::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categoriesData = [
            'Ações' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80',
            'Criptomoedas' => 'https://images.unsplash.com/photo-1518546305927-5a555bb7020d?auto=format&fit=crop&w=800&q=80',
            'Economia' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=800&q=80',
            'Fundos Imobiliários' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80',
            'Renda Fixa' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?auto=format&fit=crop&w=800&q=80',
        ];

        $newsTitles = [
            'Ações' => [
                "Petrobras anuncia pagamento recorde de dividendos",
                "Vale sofre com queda no minério de ferro",
                "Itaú supera expectativas de lucro no 3º trimestre",
                "WEG expande operações na Europa com nova fábrica",
                "Ambev relata aumento nas vendas de marcas premium",
                "Magazine Luiza foca em serviços financeiros para crescer",
                "B3 registra aumento de investidores pessoa física",
                "Ações da Tesla disparam após resultados animadores",
                "Apple planeja novos chips para dominar IA",
                "Microsoft fecha parceria bilionária na nuvem"
            ],
            'Criptomoedas' => [
                "Bitcoin ultrapassa nova marca histórica",
                "Ethereum atualiza rede reduzindo taxas",
                "Binance sofre pressão regulatória na Europa",
                "Solana atrai novos desenvolvedores de DeFi",
                "Cardano lança contratos inteligentes avançados",
                "ETF de Bitcoin à vista é aprovado nos EUA",
                "Mineradores se adaptam ao halving do Bitcoin",
                "Baleias movem milhões em Bitcoin para carteiras frias",
                "Nova criptomoeda promete transações instantâneas",
                "Bancos centrais testam suas próprias moedas digitais (CBDC)"
            ],
            'Economia' => [
                "Inflação no Brasil desacelera no mês passado",
                "Copom decide manter taxa Selic estável",
                "Desemprego atinge menor taxa dos últimos 5 anos",
                "Dólar opera em alta com tensões geopolíticas",
                "PIB cresce acima do esperado no trimestre",
                "Fed americano indica cortes de juros no próximo ano",
                "Exportações do agronegócio batem recorde",
                "Governo anuncia novo pacote de cortes de gastos",
                "Setor de serviços impulsiona recuperação econômica",
                "Mercado de trabalho formal cria milhares de vagas"
            ],
            'Fundos Imobiliários' => [
                "FIIs de galpões logísticos lideram altas do mês",
                "Novo fundo de shoppings promete dividend yield de 10%",
                "Especialistas apontam melhores FIIs de papel para 2024",
                "IFIX atinge máxima histórica puxado por fundos de tijolo",
                "Fundo imobiliário anuncia compra de grande edifício em SP",
                "Dividendos de FIIs seguem atrativos com Selic em queda",
                "Como montar uma carteira balanceada de Fundos Imobiliários",
                "Novas regras da CVM impactam ofertas de FIIs",
                "Fundos do agronegócio (Fiagro) ganham popularidade",
                "Vacância diminui em escritórios de alto padrão"
            ],
            'Renda Fixa' => [
                "Tesouro Direto tem captação líquida recorde",
                "CDBs pagando mais de 110% do CDI atraem investidores",
                "LCI e LCA sofrem alterações em regras de carência",
                "Debêntures incentivadas: o que são e como investir",
                "Especialista recomenda prefixados para travar rentabilidade",
                "Tesouro IPCA+ garante proteção contra a inflação",
                "Títulos públicos americanos atingem maior rendimento em anos",
                "Renda Fixa ou Renda Variável? Onde investir agora",
                "Cresce a emissão de CRIs e CRAs no mercado nacional",
                "Bancos oferecem condições atrativas em produtos de CDB"
            ]
        ];

        foreach ($categoriesData as $catName => $imageUrl) {
            $category = Category::create(['name' => $catName]);

            foreach ($newsTitles[$catName] as $title) {
                // Adicionar um fator aleatório na URL da imagem para burlar cache do navegador
                $randomImageUrl = $imageUrl . '&random=' . rand(1, 1000);
                
                News::create([
                    'title' => $title,
                    'content' => "Esta é uma notícia detalhada sobre " . strtolower($title) . ". O mercado financeiro está reagindo fortemente a este evento, e investidores de todo o mundo estão analisando as perspectivas a longo prazo. Especialistas sugerem manter a calma e focar na diversificação do portfólio para mitigar riscos inerentes a estas flutuações. Acompanhe o Investidor10 para atualizações em tempo real.",
                    'category_id' => $category->id,
                    'image' => $randomImageUrl,
                    // Espalhar a data de criação nos últimos 30 dias para não ficar tudo no mesmo dia
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))
                ]);
            }
        }
    }
}
