<?php

namespace Drupal\notice_api\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\notice_api\Service\NoticeApiService;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Datetime\DrupalDateTime;
use Symfony\Component\HttpFoundation\Request;

class NoticeApiController extends ControllerBase {

  protected $noticeApi;

  public function __construct(NoticeApiService $noticeApi) {
    $this->noticeApi = $noticeApi;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('notice_api.service')
    );
  }

  public function test(Request $request) {
    $page = $request->query->get('results-page');
    $page = ($page <= 0) ? 1 : $page;
    $result = [];
    $data = $this->noticeApi->fetchData(['results-page' => $page]);
    if ($data['entry']) {
        foreach ($data['entry'] as $item) {
            if ($item['id'] && $item['published'] && $item['content']) {
                $url = Url::fromUri($item['id']);
                $link = Link::fromTextAndUrl($item['title'], $url)->toRenderable();
                $item_date = new DrupalDateTime($item['published']);
                $formatte_date = $item_date->format('j F Y');
                $result[] = [
                    'title' => '<a target="_blank" href=' . $item['id']  . '>' . $item['title'] . ' </a>',
                    'publish_date' => $formatte_date,
                    'content' => $item['content']
                ];
            }
            
        }
    }

    $total = count($data);

    return [
      '#markup' => '<pre>' . print_r($result, TRUE) . '</pre>',
      '#cache' => [
            'max-age' => 0,
        ],
    ];
  }
}

