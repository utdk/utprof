<?php

namespace Drupal\utprof_block_type_profile_listing;

use Drupal\block_content\Entity\BlockContent;
use Drupal\views\Views;

/**
 * Business logic for rendering the listing view.
 */
class ProfileListingHelper {

  /**
   * Inspect block field & return a view mode.
   *
   * @param \Drupal\block_content\Entity\BlockContent $block_content
   *   The block object.
   *
   * @return string
   *   The user-selected view mode.
   */
  public static function getViewMode(BlockContent $block_content) {
    $view_mode = 'utexas_basic';
    if ($block_content->hasField('field_utprof_view_mode')) {
      $view_mode = $block_content->get('field_utprof_view_mode')->getString();
    }
    return $view_mode;
  }

  /**
   * Inspect block fields & return Views-type filter array.
   *
   * @param \Drupal\block_content\Entity\BlockContent $block_content
   *   The block object.
   *
   * @return array
   *   A Views-type options array.
   */
  public static function generateFilters(BlockContent $block_content) {
    $user_defined_filters['field_utprof_profile_groups_target_id'] = [];
    $user_defined_filters['field_utprof_profile_tags_target_id'] = [];

    if ($block_content->hasField('field_utprof_profile_groups')) {
      $groups = $block_content->get('field_utprof_profile_groups')->getValue();
      foreach ($groups as $group) {
        $target_id = $group['target_id'];
        $user_defined_filters['field_utprof_profile_groups_target_id'][] = $target_id;
      }
    }
    if ($block_content->hasField('field_utprof_profile_tags')) {
      $groups = $block_content->get('field_utprof_profile_tags')->getValue();
      foreach ($groups as $group) {
        $target_id = $group['target_id'];
        $user_defined_filters['field_utprof_profile_tags_target_id'][] = $target_id;
      }
    }
    return $user_defined_filters;
  }

  /**
   * Generate a renderable View based on user input.
   *
   * @param \Drupal\block_content\Entity\BlockContent $block_content
   *   The block object.
   *
   * @return array
   *   A render array.
   */
  public static function buildContextualView(BlockContent $block_content) {
    $user_defined_filters = self::generateFilters($block_content);
    $view_mode = self::getViewMode($block_content);
    $view = Views::getView('utprof_profiles');
    if (is_object($view)) {
      // Specify which Views display to use.
      $view->setDisplay('block_1');
      // Set view mode based on user-provided value.
      $row = $view->display_handler->getOption('row');
      $row['options']['view_mode'] = $view_mode;
      $view->display_handler->overrideOption('row', $row);

      // Set filters based on user-provided values.
      $filters = $view->display_handler->getOption('filters');
      foreach ($user_defined_filters as $field => $values) {
        if ($filters[$field]) {
          // Reset filters initially.
          $filters[$field]['value'] = [];
          foreach ($values as $value) {
            // Incrementally restrict filters ("OR" logic).
            $filters[$field]['value'][$value] = $value;
          }
        }
      }
      $view->display_handler->overrideOption('filters', $filters);
      $view->preExecute();
      $view->execute();
      return $view->buildRenderable('block_1');
    }
    return FALSE;
  }

}
