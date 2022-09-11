<?php
/**
 * @file
 * Contains \Drupal\qed_api_config\Controller\QedApiController.
 */
namespace Drupal\qed_api_config\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
// use Drupal\Core\Entity\entityTypeManager;
// use Drupal\node\NodeStorageInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class QedApiController
 */
class QedApiConfigController extends ControllerBase
{

    /**
     * This method will be called for the '/node_json/{node_id}/{api_key}' path.
     */
    public function contentResponse($node_id, $api_key){
        //use the serializer service from serializer module 
        $serializer = \Drupal::service('serializer');
        //get the site config
        $config = \Drupal::config('system.site');
        $storedapiKey = $config->get('api_key');
        if($storedapiKey == $api_key){
            $node = \Drupal::entityTypeManager()->getStorage('node');
            $nodeData = $node->load($node_id);
            $data = $serializer->serialize($nodeData, 'json', ['plugin_id' => 'entity']);
           
        }else{
          $data = [
            'http_response' => 403,
            'message'=>'access denied'

          ];
          $data = $serializer->serialize($data, 'json');
        }
        
        return JsonResponse::fromJsonString($data);
    }
}