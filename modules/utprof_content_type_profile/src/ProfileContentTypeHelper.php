<?php

namespace Drupal\utprof_content_type_profile;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\utprof_content_type_profile\Form\FormAlter;

/**
 * Business logic for rendering the content type.
 */
class ProfileContentTypeHelper {

  /**
   * Helper function to determine whether to link.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   Whether or not to link to the node.
   */
  public static function doLinkToNode(Node $node) {
    if ($node->hasField('field_utprof_listing_link') && !$node->get('field_utprof_listing_link')->isEmpty()) {
      $do_link_title = $node->get('field_utprof_listing_link')->getString();
      if ($do_link_title) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * A themed media item.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   An image render array
   */
  public static function getBasicMedia(Node $node) {
    $image_render_array = [];
    // Build basic media (headshot).
    if ($node->hasField('field_utprof_basic_media') && !$node->get('field_utprof_basic_media')->isEmpty()) {
      $headshot = $node->get('field_utprof_basic_media');
      if ($node->hasField('field_utprof_image_ratio_opt') && !$node->get('field_utprof_image_ratio_opt')->isEmpty()) {
        $use_primary_image_style = $node->get('field_utprof_image_ratio_opt');
      }
      $user_defined_image_style = $use_primary_image_style ? 'utexas_image_style_500w_500h' : 'utexas_image_style_500w';
      if ($media = \Drupal::entityTypeManager()->getStorage('media')->load($headshot->getString())) {
        $image_render_array = $media->field_utexas_media_image->view([
          'type' => 'image',
          'label' => 'hidden',
          'settings' => [
            'image_style' => $user_defined_image_style,
            'image_link' => '',
          ],
        ]);
      }
    }
    return $image_render_array;
  }

  /**
   * Return an array of building code link & room number.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   The building code information array.
   */
  public static function getBuildingInformation(Node $node) {
    // Build Building Information link.
    $building_information = [];
    $building_code_value = NULL;
    $building_code_link = NULL;
    if ($node->hasField('field_utprof_building_code') && !$node->get('field_utprof_building_code')->isEmpty()) {
      $building_code = $node->get('field_utprof_building_code');
      $url = Url::fromUri('https://utdirect.utexas.edu/apps/campus/buildings/nlogon/maps/UTM/' . $building_code->getString());
      $building_code = Link::fromTextAndUrl($building_code, $url);
      $building_code_value = $building_code->getText()->getValue()[0]['value'];
      $building_code_link = $building_code->getUrl()->getUri();
    }

    $building_room_value = NULL;
    if ($node->hasField('field_utprof_building_room_numb') && !$node->get('field_utprof_building_room_numb')->isEmpty()) {
      $building_room_value = $node->get('field_utprof_building_room_numb')->getString();
    }
    $building_information['code_value'] = $building_code_value ?? NULL;
    $building_information['code_link'] = $building_code_link ?? NULL;
    $building_information['room_number'] = $building_room_value ?? NULL;
    return $building_information;
  }

  /**
   * Link to user-provided phone.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   A renderable Drupal link.
   */
  public static function getPhone(Node $node) {
    // Build phone number link.
    $phone = [];
    if ($node->hasField('field_utprof_phone_number') && !$node->get('field_utprof_phone_number')->isEmpty()) {
      $phone_number = $node->get('field_utprof_phone_number');
      $phone_number_text = $phone_number->getString();
      $phone_link = Url::fromUri('tel:' . rawurlencode($phone_number_text));
      $phone = Link::fromTextAndUrl($phone_number_text, $phone_link);
    }
    return $phone;
  }

  /**
   * The node title, linked depending on user selection.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   * @param string $view_mode
   *   Optional view mode, setting which link class to use.
   *
   * @return array
   *   A renderable Drupal link.
   */
  public static function getPreparedTitle(Node $node, $link_class = '') {
    // Build a title field, linked conditionally.
    $title = $node->getTitle();
    if (self::doLinkToNode($node)) {
      $url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
      if (isset($link_class)) {
        $link_options = [
          'attributes' => [
            'class' => [
              $link_class,
            ],
          ],
        ];
        $url->setOptions($link_options);
      }
      return Link::fromTextAndUrl($title, $url);
    }
    return $title;
  }

  /**
   * The media item, linked depending on user selection.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   A renderable Drupal link.
   */
  public static function getListingBasicMedia(Node $node) {
    // Build basic media (headshot).
    if ($node->hasField('field_utprof_basic_media') && !$node->get('field_utprof_basic_media')->isEmpty()) {
      $headshot = $node->get('field_utprof_basic_media');
      if ($media = \Drupal::entityTypeManager()->getStorage('media')->load($headshot->getString())) {
        $image_render_array = [
          'type' => 'image',
          'label' => 'hidden',
          'settings' => [
            'image_style' => 'utexas_image_style_500w_500h',
            'image_link' => '',
          ],
        ];
        $image = $media->field_utexas_media_image->view($image_render_array);
        if (self::doLinkToNode($node)) {
          $url = Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
          return Link::fromTextAndUrl($image, $url);
        }
        return $image;
      }
    }
    return [];
  }

  /**
   * Link to user-provided site or form.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   A renderable Drupal link.
   */
  public static function getContactLink(Node $node) {
    // Build contact form link.
    $link = [];
    if ($node->hasField('field_utprof_contact_form_link') && !$node->get('field_utprof_contact_form_link')->isEmpty()) {
      $contact_link = $node->get('field_utprof_contact_form_link');
      $contact_values = $contact_link->getValue();
      $url = Url::fromUri($contact_values[0]['uri']);
      $link_options = [
        'attributes' => [
          'class' => [
            'ut-btn',
          ],
        ],
      ];
      $url->setOptions($link_options);
      $link = Link::fromTextAndUrl($contact_values[0]['title'], $url);
    }
    return $link;
  }

  /**
   * Whether or not there are contact info fields.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return bool
   *   Whether or not there are contact info fields.
   */
  public static function hasContactInfoFields(Node $node) {
    $has_contact_info = FALSE;
    foreach (FormAlter::UTPROF_CONTENT_TYPE_PROFILE_CONTACT_INFO_FIELDS as $contact_info_field) {
      if ($node->hasField($contact_info_field) && !$node->$contact_info_field->isEmpty()) {
        $has_contact_info = TRUE;
        break;
      }
    }
    return $has_contact_info;
  }

  /**
   * Link to UTexas Directory with EID parameter.
   *
   * @param Drupal\node\Entity\Node $node
   *   The node object.
   *
   * @return array
   *   A renderable Drupal link.
   */
  public static function getDirectoryLink(Node $node) {
    // Build EID link.
    $directory_link = [];
    if ($node->hasField('field_utprof_eid') && !$node->get('field_utprof_eid')->isEmpty()) {
      $eid = $node->get('field_utprof_eid');
      $url = Url::fromUri('https://directory.utexas.edu/index.php?q=' . $eid->getString());
      $link_options = [
        'attributes' => [
          'class' => [
            'ut-link--darker',
          ],
        ],
      ];
      $url->setOptions($link_options);
      $directory_link = Link::fromTextAndUrl(t('View in Directory'), $url);
    }
    return $directory_link;
  }

}
