<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        News::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $newsData = [
            'Ações' => [
                ['title' => "Petrobras anuncia pagamento recorde de dividendos", 'img' => "https://images.unsplash.com/photo-1614028674026-a65e31bfd27c?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Vale sofre com queda no minério de ferro", 'img' => "https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Itaú supera expectativas de lucro no 3º trimestre", 'img' => "https://images.unsplash.com/photo-1556740758-90de374c12ad?auto=format&fit=crop&w=800&q=80"],
                ['title' => "WEG expande operações na Europa com nova fábrica", 'img' => "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Ambev relata aumento nas vendas de marcas premium", 'img' => "https://images.unsplash.com/photo-1571115177098-24edf37825d5?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Magazine Luiza foca em serviços financeiros para crescer", 'img' => "https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "B3 registra aumento de investidores pessoa física", 'img' => "https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Ações da Tesla disparam após resultados animadores", 'img' => "https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Apple planeja novos chips para dominar IA", 'img' => "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Microsoft fecha parceria bilionária na nuvem", 'img' => "https://images.unsplash.com/photo-1633419461186-7d40a38105ec?auto=format&fit=crop&w=800&q=80"],
            ],
            'Criptomoedas' => [
                ['title' => "Bitcoin ultrapassa nova marca histórica", 'img' => "https://images.unsplash.com/photo-1518546305927-5a555bb7020d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Ethereum atualiza rede reduzindo taxas", 'img' => "https://images.unsplash.com/photo-1622630998477-20b41cd0e14f?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Binance sofre pressão regulatória na Europa", 'img' => "https://images.unsplash.com/photo-1621504450181-5d356f61d307?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Solana atrai novos desenvolvedores de DeFi", 'img' => "https://images.unsplash.com/photo-1642104704074-907c0698cbd9?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Cardano lança contratos inteligentes avançados", 'img' => "https://images.unsplash.com/photo-1639762681485-074b7f4fc8bc?auto=format&fit=crop&w=800&q=80"],
                ['title' => "ETF de Bitcoin à vista é aprovado nos EUA", 'img' => "https://images.unsplash.com/photo-1605792657660-596af9009e82?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Mineradores se adaptam ao halving do Bitcoin", 'img' => "https://images.unsplash.com/photo-1624996379697-f01d168b1a52?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Baleias movem milhões em Bitcoin para carteiras frias", 'img' => "https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Nova criptomoeda promete transações instantâneas", 'img' => "https://images.unsplash.com/photo-1621416894569-0f39ed31d247?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Bancos centrais testam suas próprias moedas digitais", 'img' => "https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?auto=format&fit=crop&w=800&q=80"],
            ],
            'Economia' => [
                ['title' => "Inflação no Brasil desacelera no mês passado", 'img' => "https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Copom decide manter taxa Selic estável", 'img' => "https://images.unsplash.com/photo-1612178991541-b48cc8e92a4d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Desemprego atinge menor taxa dos últimos 5 anos", 'img' => "https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Dólar opera em alta com tensões geopolíticas", 'img' => "https://images.unsplash.com/photo-1580519542036-ed47f3e42a98?auto=format&fit=crop&w=800&q=80"],
                ['title' => "PIB cresce acima do esperado no trimestre", 'img' => "https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Fed americano indica cortes de juros no próximo ano", 'img' => "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Exportações do agronegócio batem recorde", 'img' => "https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Governo anuncia novo pacote de cortes de gastos", 'img' => "https://images.unsplash.com/photo-1554224154-26032ffc0d07?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Setor de serviços impulsiona recuperação econômica", 'img' => "https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Mercado de trabalho formal cria milhares de vagas", 'img' => "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=800&q=80"],
            ],
            'Fundos Imobiliários' => [
                ['title' => "FIIs de galpões logísticos lideram altas do mês", 'img' => "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Novo fundo de shoppings promete dividend yield alto", 'img' => "https://images.unsplash.com/photo-1519567281027-d15c1024fe3ce?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Especialistas apontam melhores FIIs de papel", 'img' => "https://images.unsplash.com/photo-1450101499163-c8848c66cb85?auto=format&fit=crop&w=800&q=80"],
                ['title' => "IFIX atinge máxima histórica puxado por tijolo", 'img' => "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Fundo imobiliário anuncia compra de grande edifício", 'img' => "https://images.unsplash.com/photo-1481277542470-605612bd2d61?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Dividendos de FIIs seguem atrativos com Selic em queda", 'img' => "https://images.unsplash.com/photo-1579621970795-87facc2f976d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Como montar uma carteira balanceada de FIIs", 'img' => "https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Novas regras da CVM impactam ofertas de FIIs", 'img' => "https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Fundos do agronegócio ganham popularidade", 'img' => "https://images.unsplash.com/photo-1592982537447-6f2e2c2f90a9?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Vacância diminui em escritórios de alto padrão", 'img' => "https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80"],
            ],
            'Renda Fixa' => [
                ['title' => "Tesouro Direto tem captação líquida recorde", 'img' => "https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=800&q=80"],
                ['title' => "CDBs pagando mais de 110% do CDI atraem investidores", 'img' => "https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&w=800&q=80"],
                ['title' => "LCI e LCA sofrem alterações em regras de carência", 'img' => "https://images.unsplash.com/photo-1554224155-1696413565d3?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Debêntures incentivadas: o que são e como investir", 'img' => "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Especialista recomenda prefixados para rentabilidade", 'img' => "https://images.unsplash.com/photo-1553729459-efe14ef6055d?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Tesouro IPCA+ garante proteção contra a inflação", 'img' => "https://images.unsplash.com/photo-1628348070889-cb656235bdde?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Títulos públicos americanos atingem maior rendimento", 'img' => "https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Renda Fixa ou Renda Variável? Onde investir agora", 'img' => "https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Cresce a emissão de CRIs e CRAs no mercado nacional", 'img' => "https://images.unsplash.com/photo-1542222024-c39e2281f121?auto=format&fit=crop&w=800&q=80"],
                ['title' => "Bancos oferecem condições atrativas em produtos", 'img' => "https://images.unsplash.com/photo-1501167731653-c21d8035bc45?auto=format&fit=crop&w=800&q=80"],
            ]
        ];

        foreach ($newsData as $categoryName => $newsList) {
            $category = Category::create(['name' => $categoryName]);

            foreach ($newsList as $item) {
                News::create([
                    'title' => $item['title'],
                    'content' => "A matéria de hoje destaca: " . $item['title'] . ". Analistas do mercado financeiro debatem as possíveis repercussões a curto e longo prazo para os investidores do setor. Mantenha seu portfólio diversificado e acompanhe as oscilações para aproveitar as melhores janelas de oportunidade. Leia mais relatórios exclusivos assinando a plataforma Investidor10 Premium.",
                    'category_id' => $category->id,
                    'image' => $item['img'],
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))
                ]);
            }
        }
    }
}
