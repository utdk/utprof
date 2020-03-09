<?php

namespace Drupal\Tests\utprof\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Verifies Flex Page nodes revisions work without issue.
 *
 * @group utexas
 */
class ProfileCreateTest extends BrowserTestBase {

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
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = [
    'utprof',
    'utprof_content_type_profile',
    // 'utprof_role_profile_editor',
    'utprof_vocabulary_groups',
    'utprof_vocabulary_tags',
  ];

  /**
   * An user with permissions to administer content types and image styles.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $testUser;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // $this->utexasSharedSetup();
    $this->strictConfigSchema = NULL;
    parent::setUp();
    // $this->initializeProfileEditor();
    // $this->testUser = $this->drupalCreateUser(['administer nodes']);

    $this->testUser = $this->drupalCreateUser();
    $testUser = user_load_by_name($this->testUser->getAccountName());
    // $testUser->addRole('utprof_profile_editor');
    $testUser->save();
    $this->drupalLogin($this->testUser);

    // $user = $this->drupalCreateUser();
    // $user_storage = $this->container->get('entity_type.manager')->getStorage('user');
    // $user_storage->resetCache([$user->id()]);
    // $this->testUser = $user_storage->load($user->id());
    // $this->testUser->addRole('utprof_profile_editor');
    // $this->testUser->save();
    // $this->drupalLogin($this->testUser);
  }

  /**
   * Test output.
   */
  public function testProfilePage() {
    // Load the front page.
    $this->drupalGet('<front>');
    // Confirm that the site didn't throw a server error or something else.
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('/node/add/utprof_profile');
    $this->assertSession()->statusCodeEquals(200);

    // $this->verifyRevisioning();
  }

}
