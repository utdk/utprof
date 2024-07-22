<?php

namespace Drupal\Tests\utprof\Functional;

use Drupal\Tests\BrowserTestBase;
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
class NodeViewTest extends BrowserTestBase {

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
   * @see Drupal\Tests\BrowserTestBase
   */
  protected static $modules = [
    'utprof',
    'utprof_content_type_profile',
    // 'utprof_role_profile_editor',
    'utprof_vocabulary_groups',
    'utprof_vocabulary_tags',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    $this->strictConfigSchema = NULL;
    parent::setUp();
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
