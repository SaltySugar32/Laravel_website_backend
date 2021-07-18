<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductArticle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use phpQuery;

class ParseCommand extends Command
{
    protected $signature = 'ParseData';
    protected $description = 'парсим категориии и товары с сайта';

    public function __construct()
    {
        parent::__construct();
    }

    //Главная функция
    private function getData($url){
        $file = file_get_contents($url);
        $doc = phpQuery::newDocument($file);
        $categoryid=0;
        foreach ($doc->find('.sub-categories $li') as $data) {
            $categoryid=$categoryid+1;
            $data = pq($data);

            //Парсинг Категорий
            $category = $data->find('.sub-cat-name')->text();
            $category = rtrim($category, '.');
            Category::create(['name'=>$category]);


            //Переход на странички категорий для поиска товаров
            $productlink = $data->find('$a')->attr('href');
            $this->getProducts($productlink, $categoryid);
        }
        return true;
    }

    //Парсинг Товаров
    private function getProducts($url, $categoryid){
        $file = file_get_contents($url);
        $doc = phpQuery::newDocument($file);
        foreach($doc->find('.products-wrapper .product-wrapper') as $data){
            $data =pq($data);

            $title = $data->find('.product-name $a')->text();

            $img=$data->find('.product-image $a $img')->attr('src');

            $description=$data->find('.product-description')->text();
            $description=trim($description);

            $price = $data->find('.product-footer .product-price .product-default-price')->text();
            $price=trim($price);
            $price=str_replace(' ', '', $price);
            $price=intval($price);


            Product::create([
                'category_id'=>$categoryid,
                'amount'=>500,
                'price'=>$price,
                'storage_id'=>rand(1,5)]);

            $productid=DB::table('products')->orderByDesc('id')->first()->id;

            ProductArticle::create([
                'product_id'=>$productid,
                'title'=>$title,
                'description'=>$description,
                'short_description'=>$description,
                'picture_link'=>$img]);
        }
    }

    public function handle()
    {
        require_once('phpQuery.php');
        $url='https://www.dunavl.ru/stroitelnye-materialy';
        $this->getData($url);
    }

}
?>
