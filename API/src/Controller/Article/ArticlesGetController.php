<?php 

use Src\Service\Article\ArticlesSearcherService;

final readonly class ArticlesGetController {

    private ArticlesSearcherService $service;

    public function __construct() {
        $this->service = new ArticlesSearcherService();
    }

    public function start(): void 
    {
        $response = $this->service->search();

        $filtered = $this->filterResponses($response);
        // limpiamos los datos para evitar errores de json_encode//
        $cleanedArticles = array_map(function($article) {
            foreach ($article as $key => $value) {
                
                if (is_object($value) && !($value instanceof \DateTime)) {
                    $article[$key] = null;
                }
                if (is_resource($value)) {
                    $article[$key] = null;
                }
            }

            //aseguramos que la imagen tenga algún valor//
            if (empty($article['image'])) {
                $article['image'] = 'placeholder.jpeg';
            }

            return $article;
        }, $filtered);

        // Convertimos a JSON //
        $json = json_encode($cleanedArticles);

        if ($json === false) {
            var_dump(json_last_error_msg(), $cleanedArticles);
            exit;
        }

        echo $json;
        exit;
    }

    private function filterResponses(array $responses): array
    {
        $result = [];

        foreach ($responses as $response) {
            $result[] = [
                "id" => $response->id(),
                "title" => $response->title(),
                "image" => $response->image(),
                "body" => $response->body(),
                "date" => $response->date() instanceof \DateTime 
                          ? $response->date()->format('Y-m-d H:i:s') 
                          : null
            ];
        }

        return $result;
    }
}



