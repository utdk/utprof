<?php

namespace Drupal\Tests\utprof\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

use Drupal\Tests\TestFileCreationTrait;

use Drupal\Tests\utprof\Traits\EntityTestTrait;
use Drupal\Tests\utprof\Traits\ProfileTestTrait;
use Drupal\Tests\utprof\Traits\UserTestTrait;

/**
 * Test all aspects of Profile Listing block functionality.
 *
 * @group utexas
 */
class BlockCreationTest extends WebDriverTestBase {

  use TestFileCreationTrait;
  use EntityTestTrait;
  use UserTestTrait;

  use ProfileTestTrait;

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
    'utprof_block_type_profile_listing',
    // 'utprof_view_profiles',
    'utprof_vocabulary_groups',
    'utprof_vocabulary_tags',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->strictConfigSchema = NULL;
    parent::setUp();

    $this->entityTypeManager = $this->container->get('entity_type.manager');
    $this->renderer = $this->container->get('renderer');
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('node');

    $this->testMediaImageId = $this->createTestMediaImage();
    $this->testMediaImageFilename = $this->entityTypeManager->getStorage('media')
      ->load($this->testMediaImageId)
      ->get('field_utexas_media_image')
      ->entity
      ->getFileName();

    $this->node = $this->createProfileNode($this->testMediaImageId);

    $this->drupalLogin($this->rootUser);
  }

  /**
   * Test Profile List block and output.
   */
  public function testCreateProfileListingBlock() {
    $session = $this->getSession();
    // Enlarge the viewport so that all is clickable.
    $session->resizeWindow(1200, 3000);
    $this->drupalGet('block/add/utprof_profile_listing');

    $page = $session->getPage();
    $assert = $this->assertSession();

    // Add field values.
    $page->fillField('info[0][value]', 'Test Profile Listing Block Description');
    // Set "Profiles Display Format" (node view mode) radio button.
    $page->selectFieldOption('edit-field-utprof-view-mode-nodeutexas-basic', 'node.utexas_basic');
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_header[0][value]', 'Header text');
    // Set "Limit Profiles to the following group(s)" (taxonomy terms).
    $page->findField('field_utprof_profile_groups[1]')->click();
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_footer[0][value]', 'Footer text');
    // Save block content.
    $page->pressButton('Save');
    $assert->waitForText('Profile Listing Test Profile Listing Block Description has been created.');
    // Place block in "Content" region on all pages.
    $this->submitForm([
      'region' => 'content',
    ], 'Save block');
    $assert->waitForText('The block configuration has been saved.');
    // Verify page output.
    $this->drupalGet('<front>');
    $assert->elementExists('css', '.utexas_basic');

    // Load block by title to get the id.
    $block = $this->drupalGetBlockByInfo('Test Profile Listing Block Description');

    // Set display to "Name Only".
    $this->drupalGet('block/' . $block->id());
    // Set "Profiles Display Format" (node view mode) radio button.
    $page->selectFieldOption('edit-field-utprof-view-mode-nodeutexas-name-only', 'node.utexas_name_only');
    $page->pressButton('Save');
    $assert->waitForText('The block configuration has been saved.');
    // Verify page output.
    $this->drupalGet('<front>');
    $assert->elementExists('css', '.utexas-name-only');

    // Set display to "Prominent".
    $this->drupalGet('block/' . $block->id());
    // Set "Profiles Display Format" (node view mode) radio button.
    $page->selectFieldOption('edit-field-utprof-view-mode-nodeutexas-prominent', 'node.utexas_prominent');
    $page->pressButton('Save');
    $assert->waitForText('The block configuration has been saved.');
    // Verify page output.
    $this->drupalGet('<front>');
    $assert->elementExists('css', '.utexas_prominent');
  }

}
