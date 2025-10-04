<?php 

use Src\Service\Article\ArticlesSearcherService;

final readonly class ArticlesGetController {

    private ArticlesSearcherService $service;

    public function __construct() {
        $this->service = new ArticlesSearcherService();
    }

    public function start(): void 
    {
    
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6; 
        $offset = ($page - 1) * $limit;

        $response = $this->service->search($limit, $offset); 
        $total = $this->service->countArticles(); 

        
        $filtered = $this->filterResponses($response);

        $cleanedArticles = array_map(function($article) {
            foreach ($article as $key => $value) {
                if (is_object($value) && !($value instanceof \DateTime)) {
                    $article[$key] = null;
                }
                if (is_resource($value)) {
                    $article[$key] = null;
                }
            }
            if (empty($article['image'])) {
                $article['image'] = 'placeholder.jpeg';
            }
            return $article;
        }, $filtered);

        $result = [
            "data" => $cleanedArticles,
            "page" => $page,
            "limit" => $limit,
            "total" => $total,
            "totalPages" => ceil($total / $limit)
        ];

        $json = json_encode($result);

        if ($json === false) {
            var_dump(json_last_error_msg(), $result);
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
