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

        // Aplicamos filterResponses para formatear los artículos
        $filtered = $this->filterResponses($response);
        
        $MINIO_URL = "http://172.24.224.1:9000/imagenes/";

        // Limpiamos cada artículo para que sea serializable y seguro
        $cleanedArticles = array_map(function($article) use ($MINIO_URL) {
            foreach ($article as $key => $value) {
                // Si hay objetos o recursos inesperados, los reemplazamos por null
                if (is_object($value) && !($value instanceof \DateTime)) {
                    $article[$key] = null;
                }
                if (is_resource($value)) {
                    $article[$key] = null;
                }
            }

            // Aseguramos que la imagen tenga algún valor
            if (empty($article['image'])) {
                $article['image'] = 'placeholder.jpeg';
            }
            $article['image'] = $MINIO_URL . $article['image'];

            return $article;
        }, $filtered);

        // Convertimos a JSON
        $json = json_encode($cleanedArticles);

        // Depuración si algo falla
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



/*use Src\Service\Article\ArticlesSearcherService;

final readonly class ArticlesGetController {

    private ArticlesSearcherService $service;

    public function __construct() {
        $this->service = new ArticlesSearcherService();
    }

    public function start(): void 
    {
        $response = $this->service->search();
        echo json_encode($this->filterResponses($response));

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
                "date" => $response->date()->format('Y-m-d H:i:s')
            ];
        }

        return $result;
    }
}*/
