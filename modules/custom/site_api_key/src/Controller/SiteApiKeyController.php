<?php

namespace Drupal\site_api_key\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * SiteApiKeyController controller.
 */
class SiteApiKeyController extends ControllerBase {

  /**
   * Returns Json of node page.
   */
  public function content($api_key, NodeInterface $node) {
    $config = \Drupal::config('system.site')->get('siteapikey');
    if (isset($node)) {
      if ($api_key != $config || $node->get('type')->target_id != 'page') {
        throw new AccessDeniedHttpException();
      }
      else {

        $json_array['data'] = array(
          'type' => $node->get('type')->target_id,
          'id' => $node->get('nid')->value,
          'attributes' => array(
            'title' => $node->get('title')->value,
            'content' => $node->get('body')->value,
          ),
        );

        return new JsonResponse($json_array);
      }
    }
  }

}
