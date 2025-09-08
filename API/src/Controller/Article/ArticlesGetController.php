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
        echo json_encode($this->filterResponses($response), true);
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
}
