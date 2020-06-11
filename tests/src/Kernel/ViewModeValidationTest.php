<?php

namespace Drupal\Tests\utprof\Kernel;

use Drupal\KernelTests\Core\Entity\EntityKernelTestBase;
use Drupal\Tests\TestFileCreationTrait;

use Drupal\Tests\utprof\Traits\EntityTestTrait;
use Drupal\Tests\utprof\Traits\ProfileTestTrait;
use Drupal\Tests\utprof\Traits\UserTestTrait;

use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeBasicTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeDefaultTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeFullTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeNameOnlyTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeProminentTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeTeaserTrait;

/**
 * Verifies that display modes for Profiles behave as expected.
 *
 * @group utexas
 */
class ViewModeValidationTest extends EntityKernelTestBase {

  use TestFileCreationTrait;
  use EntityTestTrait;
  use UserTestTrait;
  use ProfileTestTrait;

  use ProfileViewModeBasicTrait;
  use ProfileViewModeDefaultTrait;
  use ProfileViewModeFullTrait;
  use ProfileViewModeNameOnlyTrait;
  use ProfileViewModeProminentTrait;
  use ProfileViewModeTeaserTrait;

  /**
   * Use the 'utexas' installation profile.
   *
   * @var string
   */
  protected $profile = 'utexas';

  /**
   * Specify the theme to be used in testing.
   *
   * @var string
   */
  protected $defaultTheme = 'forty_acres';

  /**
   * Modules to enable.
   *
   * @var array
   *
   * @see Drupal\KernelTests\Core\Entity\EntityKernelTestBase
   */
  public static $modules = [
    // Core modules.
    'file',
    'image',
    'node',
    'media',
    'media_library',
    'link',
    'taxonomy',
    'views',
    'editor',
    'filter',
    // UTexas Profile modules.
    'utexas_media_types',
    'utexas_image_styles',
    'utexas_form_elements',
    // 'utexas_text_format_flex_html',
    // Contrib modules.
    'bootstrap_horizontal_tabs',
    'breadcrumbs_visibility',
    // UTexas contrib modules.
    'utprof',
    'utprof_content_type_profile',
    'utprof_vocabulary_groups',
    'utprof_vocabulary_tags',
    // 'utexas_qualtrics_filter',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->strictConfigSchema = NULL;
    parent::setUp();

    $this->installSchema('file', ['file_usage']);
    $this->installEntitySchema('file');
    $this->installEntitySchema('media');
    $this->installEntitySchema('taxonomy_term');
    $this->installEntitySchema('taxonomy_vocabulary');
    $this->installEntitySchema('filter_format');
    $this->installConfig('system');
    $this->installConfig('node');
    $this->installConfig('media_library');
    $this->installConfig('views');
    $this->installConfig('taxonomy');
    $this->installConfig('filter');

    $this->setInstallProfile($this->profile);
    \Drupal::service('config.installer')->installOptionalConfig();

    $this->installConfig('bootstrap_horizontal_tabs');
    $this->installConfig('breadcrumbs_visibility');
    $this->installConfig('utexas_media_types');
    $this->installConfig('utexas_image_styles');
    $this->installConfig('utexas_form_elements');
    $this->installConfig('utprof_content_type_profile');
    // $this->installConfig('utexas_text_format_flex_html');

    $this->testImageId = $this->createTestMediaImage();
    $this->node = $this->createProfileNode($this->testImageId);

    $this->entityTypeManager = $this->container->get('entity_type.manager');
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('node');
    $this->renderer = $this->container->get('renderer');
  }

  /**
   * Test Profile content type and output by view mode.
   */
  public function testViewModeValidation() {
    $this->verifyProfileViewModeBasic();
    $this->verifyProfileViewModeDefault();
    $this->verifyProfileViewModeFull();
    $this->verifyProfileViewModeNameOnly();
    $this->verifyProfileViewModeProminent();
    $this->verifyProfileViewModeTeaser();
  }

}
