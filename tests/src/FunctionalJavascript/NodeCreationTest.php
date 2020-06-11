<?php

namespace Drupal\Tests\utprof\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

use Drupal\Tests\TestFileCreationTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;
use Drupal\Tests\utprof\Traits\EntityTestTrait;
use Drupal\Tests\utprof\Traits\UserTestTrait;

use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeBasicTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeDefaultTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeFullTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeNameOnlyTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeProminentTrait;
use Drupal\Tests\utprof\Traits\ViewModeTests\ProfileViewModeTeaserTrait;

/**
 * Test all aspects of Profile Node creation functionality.
 *
 * @group utexas
 */
class NodeCreationTest extends WebDriverTestBase {

  use TestFileCreationTrait;
  use NodeCreationTrait;
  use EntityTestTrait;
  use UserTestTrait;

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

    $this->drupalLogin($this->rootUser);
  }

  /**
   * Test Profile content type and output.
   */
  public function testCreateProfileNode() {
    // Enlarge the viewport so that all is clickable.
    $this->getSession()->resizeWindow(1200, 3000);
    $this->drupalGet('node/add/utprof_profile');

    $page = $this->getSession()->getPage();
    $assert = $this->assertSession();

    // Add field values for second tab.
    // Click on second horizontal tab ("Basic Information").
    $horizontal_tabs = $page->findAll('css', '.horizontal-tab-button-1');
    $horizontal_tabs[0]->click();
    // Add field values.
    $page->fillField('title[0][value]', 'Test Profile Page title');
    $page->fillField('field_utprof_given_name[0][value]', 'Profile Test Given Name');
    $page->fillField('field_utprof_surname[0][value]', 'Profile Test Surname');
    $page->fillField('field_utprof_eid[0][value]', 'myeid');
    $page->fillField('field_utprof_designation[0][value]', 'Designation 1');
    // Add additional designation field value.
    $page->pressButton('edit-field-utprof-designation-add-more');
    $assert->assertWaitOnAjaxRequest();
    $page->fillField('field_utprof_designation[1][value]', 'Designation 2');
    // Add media item.
    $page->pressButton('edit-field-utprof-basic-media-open-button');
    $assert->assertWaitOnAjaxRequest();
    // Select the test media item ("Image 1" with file name "test-image.png").
    $assert->elementExists('css', 'img[src*="' . $this->testMediaImageFilename . '"]')->click();
    $assert->elementExists('css', '.ui-dialog-buttonset')->pressButton('Insert selected');
    $assert->assertWaitOnAjaxRequest();
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_add_basic_info[0][value]', 'Basic info text');

    // Add field values for third tab.
    // Click on third horizontal tab ("Main Content").
    $horizontal_tabs = $page->findAll('css', '.horizontal-tab-button-2');
    $horizontal_tabs[0]->click();
    // Add first content tab values.
    $page->fillField('field_utprof_content[0][header]', 'Test Profile Page content tab 1 header text');
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_content[0][body][value]', 'Test Profile Page content tab 1 body text');
    // Add additional content tab values.
    $page->pressButton('edit-field-utprof-content-add-more');
    $assert->assertWaitOnAjaxRequest();
    $page->fillField('field_utprof_content[1][header]', 'Test Profile Page content tab 2 header text');
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_content[1][body][value]', 'Test Profile Page content tab 2 body text');

    // Add field values for fourth tab.
    // Click on fourth horizontal tab ("Contact Information").
    $horizontal_tabs = $page->findAll('css', '.horizontal-tab-button-3');
    $horizontal_tabs[0]->click();
    // Add field values.
    $page->fillField('field_utprof_email_address[0][value]', 'email@address.com');
    $page->fillField('field_utprof_website_link[0][uri]', 'https://www.yahoo.com');
    $page->fillField('field_utprof_website_link[0][title]', 'Profile Test Website Link title');
    $page->fillField('field_utprof_building_code[0][value]', 'FAC');
    $page->fillField('field_utprof_building_room_numb[0][value]', 'Room Number');
    $page->fillField('field_utprof_fax_number[0][value]', '512-123-4567');
    $page->fillField('field_utprof_phone_number[0][value]', '512-234-5678');
    $page->fillField('field_utprof_contact_form_link[0][uri]', 'https://www.google.com');
    $page->fillField('field_utprof_contact_form_link[0][title]', 'Contact me here');
    // Assign value using CKEditor enabled field.
    $this->setCkeditorField('field_utprof_add_contact_info[0][value]', 'Contact info text');

    // Submit form.
    $page->pressButton('edit-submit');
    // Content creation confirmation message includes a link, so we only verify
    // the end of the message.
    $assert->waitForText('has been created.');

    // $this->node is used in the verify functions below.
    $this->node = $this->getNodeByTitle('Test Profile Page title');

    $this->verifyProfileViewModeBasic();
    $this->verifyProfileViewModeDefault();
    $this->verifyProfileViewModeFull();
    $this->verifyProfileViewModeNameOnly();
    $this->verifyProfileViewModeProminent();
    $this->verifyProfileViewModeTeaser();
  }

}
