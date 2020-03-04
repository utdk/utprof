<?php

/**
 * @file
 * Content for creating default content.
 */

$default_profile_nodes[] = [
  'title' => t('Sample Profile (minimal content)'),
  'profile_groups' => [
    'Faculty',
    'Staff',
  ],
  'fields' => [
    'field_utprof_given_name' => 'Sample',
    'field_utprof_surname' => 'Content',
  ],
];

$filepath_1 = drupal_get_path('module', 'utprof_content_type_profile') . '/assets/general-2.jpg';
$default_profile_nodes[] = [
  'title' => t('Sample Profile (maximal content)'),
  'profile_groups' => [
    'Leadership',
  ],
  'basic_media' => [
    'filepath' => $filepath_1,
    'filename' => t('Valeria Messalina'),
    'alt_text' => t('Roman statue'),
    'title_text' => t('Bust of Roman statue'),
  ],
  'fields' => [
    'field_utprof_add_contact_info' => [
      'value' => 'Main Building (MAI)<br />110 Inner Campus Drive<br />Austin, TX 78705',
      'format' => 'flex_html',
    ],
    'field_utprof_add_basic_info' => [
      'value' => 'The third wife of the Roman emperor Claudius, she was a paternal cousin of Emperor Nero.',
      'format' => 'flex_html',
    ],
    'field_utprof_building_code' => 'FAC',
    'field_utprof_building_room_numb' => '326T',
    'field_utprof_contact_form_link' => [
      'title' => 'Subscribe to the Newsletter',
      'uri' => 'https://utexas.qualtrics.com/SE/?SID=SV_af1Gk9JWK2khAEJ',
    ],
    'field_utprof_content' => [
      0 => [
        'header' => 'History',
        'body_value' => 'Messalina was born around 20 AD. She was a cousin of Nero and Caligula, and became empress when she married Claudius. Along with Augustus’ daughter Julia (who he had banished for sleeping with so many different men), Messalina is probably one of the most notoriously promiscuous women of Rome. Image used under the <a href="https://flic.kr/p/z4EhPK">FlickR Creative Commons</a> license.',
        'body_format' => 'flex_html',
      ],
      1 => [
        'header' => 'Later Work',
        'body_value' => "One of the few avenues to drawing a moral lesson from the story of Messalina in painting was to picture her violent end. An early example was Francesco Solimena's The Death of Messalina (1708).[46] In this scene of vigorous action, a Roman soldier pulls back his arm to stab the Empress while fending off her mother. A witness in armour observes calmly from the shadows in the background. Georges Rochegrosse's painting of 1916 is a reprise of the same scene.",
        'body_format' => 'flex_html',
      ],
    ],
    'field_utprof_designation' => [
      0 => ['value' => 'Consul'],
      1 => ['value' => 'Procurator'],
    ],
    'field_utprof_eid' => 'vm123',
    'field_utprof_email_address' => 'valeria.messalina@bmail.com',
    'field_utprof_fax_number' => '123-456-7890',
    'field_utprof_given_name' => 'Valeria',
    'field_utprof_phone_number' => '234-567-8901',
    'field_utprof_surname' => 'Messalina',
    'field_utprof_website_link' => [
      'title' => 'Personal website of Messalina',
      'uri' => 'https://example.com',
    ],
  ],
];

$filepath_2 = drupal_get_path('module', 'utprof_content_type_profile') . '/assets/rodin-young-girl.jpg';
$default_profile_nodes[] = [
  'title' => t('Gnaeus Scipio Calvus'),
  'profile_groups' => [
    'Leadership',
  ],
  'basic_media' => [
    'filepath' => $filepath_2,
    'filename' => t('Gnaeus Scipio Calvus'),
    'alt_text' => t('Roman statue'),
    'title_text' => t('Bust of Roman statue'),
  ],
  'fields' => [
    'field_utprof_given_name' => 'Gnaeus',
    'field_utprof_phone_number' => '234-567-8901',
    'field_utprof_surname' => 'Scipio Calvus',
    'field_utprof_content' => [
      0 => [
        'header' => 'History',
        'body_value' => 'His father was Lucius Cornelius Scipio, son of the patrician censor of 280, Lucius Cornelius Scipio Barbatus. His younger brother was Publius Cornelius Scipio, father of the most famous Scipio – Scipio Africanus. Gnaeus Cornelius Scipio Calvus served as consul in 222 BC, his co-consul being Marcus Claudius Marcellus, who was serving in the first of his five consulships. Gnaeus Cornelius Scipio was nicknamed Calvus (the bald) to distinguish him from his uncle, another Gnaeus Cornelius Scipio, who was nicknamed Asina (or donkey) and had twice been consul during the First Punic War. Image used under the <a href="https://flic.kr/p/z8DxzN">FlickR Creative Commons</a> license.',
        'body_format' => 'flex_html',
      ],
    ],
  ],
];

$filepath_3 = drupal_get_path('module', 'utprof_content_type_profile') . '/assets/jupiter.jpg';
$default_profile_nodes[] = [
  'title' => t('Cornelia Africana'),
  'profile_groups' => [
    'Faculty',
  ],
  'basic_media' => [
    'filepath' => $filepath_3,
    'filename' => t('Cornelia Africana'),
    'alt_text' => t('Roman statue'),
    'title_text' => t('Bust of Roman statue'),
  ],
  'fields' => [
    'field_utprof_given_name' => 'Cornelia',
    'field_utprof_surname' => 'Africana',
    'field_utprof_content' => [
      0 => [
        'header' => 'History',
        'body_value' => 'Cornelia Africana was the daughter of Scipio Africanus, famous for his victory against Hannibal in the Second Punic War. She died at age 90 in 100 BC, and was remembered by the Romans as an exemplar of virtue. Image used under the <a href="https://flic.kr/p/c5nnjU">FlickR Creative Commons</a> license.',
        'body_format' => 'flex_html',
      ],
    ],
  ],
];

$filepath_4 = drupal_get_path('module', 'utprof_content_type_profile') . '/assets/kouros.jpg';
$default_profile_nodes[] = [
  'title' => t('Portia Catonis'),
  'profile_groups' => [
    'Faculty',
    'Staff',
  ],
  'basic_media' => [
    'filepath' => $filepath_4,
    'filename' => t('Portia Catonis'),
    'alt_text' => t('Roman statue'),
    'title_text' => t('Bust of Roman statue'),
  ],
  'fields' => [
    'field_utprof_given_name' => 'Portia',
    'field_utprof_surname' => 'Catonis',
    'field_utprof_content' => [
      0 => [
        'header' => 'History',
        'body_value' => 'Porcia lived from around 70 to 42 BC. Porcia was the daughter of Cato the Younger, but is most famous as the wife to Marcus Junius Brutus. Porcia was considered to be both kind and brave, and was a lover of philosophy. Her first marriage was to Bibulus, an ally of Cato. Image used under the <a href="https://flic.kr/p/u4QJK">FlickR Creative Commons</a> license.',
        'body_format' => 'flex_html',
      ],
    ],
  ],
];

$filepath_5 = drupal_get_path('module', 'utprof_content_type_profile') . '/assets/general-1.jpg';
$default_profile_nodes[] = [
  'title' => t('Marcus Tullius Cicero'),
  'profile_groups' => [
    'Faculty',
    'Staff',
  ],
  'basic_media' => [
    'filepath' => $filepath_5,
    'filename' => t('Marcus Tullius Cicero'),
    'alt_text' => t('Roman statue'),
    'title_text' => t('Bust of Roman statue'),
  ],
  'fields' => [
    'field_utprof_given_name' => 'Marcus',
    'field_utprof_surname' => 'Tullius Cicero',
    'field_utprof_content' => [
      0 => [
        'header' => 'History',
        'body_value' => 'Marcus Tullius Cicero was a Roman philosopher, politician, lawyer, orator, political theorist, consul and constitutionalist. He came from a wealthy municipal family of the Roman equestrian order, and is widely considered one of Rome\'s greatest orators and prose stylists. Image used under the <a href="https://flic.kr/p/k9fy44">FlickR Creative Commons</a> license.',
        'body_format' => 'flex_html',
      ],
    ],
  ],
];