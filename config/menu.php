<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'routeName' => 'dashboard',
        'icon' => 'mdi mdi-home menu-icon',
    ],
    // 'master' => [
    //     'title' => 'Master',
    //     'routeName' => 'master-groups.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         'master-group' => [
    //             'title' => 'Master Group',
    //             'routeName' => 'master-groups.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'ability-master-course' => [
    //             'title' => 'Master Ability Course',
    //             'routeName' => 'master-ability-courses.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'ability-master-course-level' => [
    //             'title' => 'Master Ability Level',
    //             'routeName' => 'master-ability-course-levels.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'ability-course' => [
    //             'title' => 'Kursus Ability',
    //             'routeName' => 'ability-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'ability-question' => [
    //             'title' => 'Test / Pertanyaan',
    //             'routeName' => 'ability-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    'room-1' => [
        'title' => 'Hiragana / Katakana',
        'routeName' => 'letters.index',
        'additional_query' => '',
        'icon' => 'mdi mdi-comment-text-outline menu-icon',
        'sub_menu' => [
            // 'letter_category' => [
            //     'title' => 'Kategori Kata',
            //     'routeName' => 'letter-categories.index',
            //     'icon' => 'mdi mdi-flag menu-icon',
            // ],
            // 'letter' => [
            //     'title' => 'Daftar Kata',
            //     'routeName' => 'letters.index',
            //     'additional_query' => '',
            //     'icon' => 'mdi mdi-flag menu-icon',
            // ],
            'letter-hiragana' => [
                'title' => 'Hiragana',
                'routeName' => 'letter-hiragana-list',
                'additional_query' => 'hiragana',
                'cid' => 1,
                'icon' => 'mdi mdi-flag menu-icon',
            ],
            'letter-katakana' => [
                'title' => 'Katakana',
                'routeName' => 'letter-katakana-list',
                'additional_query' => 'katakana',
                'cid' => 2,
                'icon' => 'mdi mdi-flag menu-icon',
            ],
            'letter-course' => [
                'title' => 'Versi Test',
                'routeName' => 'letter-courses.index',
                'additional_query' => '',
                'icon' => 'mdi mdi-flag menu-icon',
            ],
            'letter-question' => [
                'title' => 'Daftar Pertanyaan',
                'routeName' => 'letter-questions.index',
                'additional_query' => '',
                'icon' => 'mdi mdi-flag menu-icon',
            ]
        ]
    ],
    'bunpou' => [
        'title' => 'Bunpou',
        'routeName' => 'bunpou.intro.index',
        'additional_query' => '',
        'icon' => 'mdi mdi-comment-text-outline menu-icon',
        'sub_menu' => [
            'intro' => [
                'title' => 'Introduction',
                'routeName' => 'bunpou.intro.index',
                'icon' => 'mdi mdi-flag menu-icon',
            ],
            'modules' => [
                'title' => 'Modules',
                'routeName' => 'bunpou.module.index',
                'icon' => 'mdi mdi-flag menu-icon',
            ],
            'chapters' => [
                'title' => 'Chapters',
                'routeName' => 'bunpou.chapter.index',
                'icon' => 'mdi mdi-flag menu-icon',
            ],
        ]
    ],
    // 'room-2' => [
    //     'title' => 'Room 2',
    //     'routeName' => 'vocabularies.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         // 'vocabulary-group' => [
    //         //     'title' => 'Group Kosa Kata',
    //         //     'routeName' => 'vocabulary-groups.index',
    //         //     'additional_query' => '',
    //         //     'icon' => 'mdi mdi-flag menu-icon',
    //         // ],
    //         'vocabulary-chapter' => [
    //             'title' => 'Bab Kosakata',
    //             'routeName' => 'vocabulary-chapters.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'vocabularies' => [
    //             'title' => 'Kosakata',
    //             'routeName' => 'vocabularies.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'vocabulary-course-chapter' => [
    //             'title' => 'Bab Test Kosakata',
    //             'routeName' => 'vocabulary-course-chapters.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'vocabulary-course' => [
    //             'title' => 'Level Test Kosakata',
    //             'routeName' => 'vocabulary-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'vocabulary-question' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'vocabulary-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         // 'vocabulary-mini-course-chapter' => [
    //         //     'title' => 'Mini Bab Test Kosakata',
    //         //     'routeName' => 'vocabulary-mini-course-chapters.index',
    //         //     'additional_query' => '',
    //         //     'icon' => 'mdi mdi-flag menu-icon',
    //         // ],
    //         'vocabulary-course-mini' => [
    //             'title' => ' Mini Level Test Kosakata',
    //             'routeName' => 'vocabulary-mini-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'vocabulary-question-mini' => [
    //             'title' => 'Daftar Mini Pertanyaan',
    //             'routeName' => 'vocabulary-mini-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    // 'room-3' => [
    //     'title' => 'Room 3',
    //     'routeName' => 'particle-educations.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         'particle-education-chapter' => [
    //             'title' => 'Bab Partikel',
    //             'routeName' => 'particle-education-chapters.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-education' => [
    //             'title' => 'Partikel',
    //             'routeName' => 'particle-educations.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-education-detail' => [
    //             'title' => 'Partikel Detail',
    //             'routeName' => 'particle-education-details.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-course' => [
    //             'title' => 'Partikel Test',
    //             'routeName' => 'particle-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-question' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'particle-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-course-mini' => [
    //             'title' => 'Partikel Mini Test',
    //             'routeName' => 'particle-mini-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'particle-question-mini' => [
    //             'title' => 'Daftar Mini Pertanyaan',
    //             'routeName' => 'particle-mini-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],

    // 'room-4' => [
    //     'title' => 'Room 4',
    //     'routeName' => 'verb-levels.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         'verb-level' => [
    //             'title' => 'Level Kata Kerja',
    //             'routeName' => 'verb-levels.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-group' => [
    //             'title' => 'Grup Kata Kerja',
    //             'routeName' => 'verb-groups.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-word' => [
    //             'title' => 'Kata Kerja',
    //             'routeName' => 'verb-words.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-change' => [
    //             'title' => 'Perubahan Kata Kerja',
    //             'routeName' => 'verb-changes.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-sentence' => [
    //             'title' => 'Kalimat Kata Kerja',
    //             'routeName' => 'verb-sentences.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-course' => [
    //             'title' => 'Test Kata Kerja',
    //             'routeName' => 'verb-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-question' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'verb-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-course-mini' => [
    //             'title' => 'Test Kata Kerja Mini',
    //             'routeName' => 'verb-mini-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'verb-question-mini' => [
    //             'title' => 'Daftar Mini Pertanyaan',
    //             'routeName' => 'verb-mini-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    // 'room-5' => [
    //     'title' => 'Room 5',
    //     'routeName' => 'pattern-chapters.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         'particle-education' => [
    //             'title' => 'Pola Bab',
    //             'routeName' => 'pattern-chapters.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'pattern-lesson' => [
    //             'title' => 'Pola Master',
    //             'routeName' => 'pattern-lessons.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'pattern-course' => [
    //             'title' => 'Pola Test',
    //             'routeName' => 'pattern-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'pattern-question' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'pattern-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'pattern-course-mini' => [
    //             'title' => 'Pola Mini Test',
    //             'routeName' => 'pattern-mini-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'pattern-question-mini' => [
    //             'title' => 'Daftar Mini Pertanyaan',
    //             'routeName' => 'pattern-mini-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    // 'room-6' => [
    //     'title' => 'Room 6',
    //     'routeName' => 'kanji-chapters.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         // 'kanji-group' => [
    //         //     'title' => 'Master Group',
    //         //     'routeName' => 'master-groups.index',
    //         //     'icon' => 'mdi mdi-flag menu-icon',
    //         // ],
    //         'kanji-chapter' => [
    //             'title' => 'Bab',
    //             'routeName' => 'kanji-chapters.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-education' => [
    //             'title' => 'Edukasi Kanji',
    //             'routeName' => 'kanji-educations.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-sample' => [
    //             'title' => 'Contoh Kanji',
    //             'routeName' => 'kanji-samples.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-course' => [
    //             'title' => 'Level Kanji',
    //             'routeName' => 'kanji-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-question' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'kanji-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-course-mini' => [
    //             'title' => 'Level Mini Kanji',
    //             'routeName' => 'kanji-mini-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'kanji-question-mini' => [
    //             'title' => 'Daftar Mini Pertanyaan',
    //             'routeName' => 'kanji-mini-course-questions.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    // 'room-7' => [
    //     'title' => 'Room 7',
    //     'routeName' => 'ability-course-chapters.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-comment-text-outline menu-icon',
    //     'sub_menu' => [
    //         'ability-course-chapter' => [
    //             'title' => 'Bab',
    //             'routeName' => 'ability-course-chapters.index',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         // 'ability-master-course-level' => [
    //         //     'title' => 'Master Ability Level',
    //         //     'routeName' => 'master-ability-course-levels.index',
    //         //     'icon' => 'mdi mdi-flag menu-icon',
    //         // ],
    //         'ability-course' => [
    //             'title' => 'Level Kemampuan',
    //             'routeName' => 'ability-courses.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ],
    //         'ability-question-group' => [
    //             'title' => 'Daftar Pertanyaan',
    //             'routeName' => 'ability-course-question-groups.index',
    //             'additional_query' => '',
    //             'icon' => 'mdi mdi-flag menu-icon',
    //         ]
    //     ]
    // ],
    'master-setting' => [
        'title' => 'Master Setting',
        'routeName' => 'user.index',
        'additional_query' => '',
        'icon' => 'mdi mdi-settings menu-icon',
        'sub_menu' => [
            'user-list' => [
                'title' => 'User',
                'routeName' => 'user.index',
                'icon' => 'mdi mdi-account-multiple menu-icon',
            ],
            'member-list' => [
                'title' => 'Member',
                'routeName' => 'member.index',
                'icon' => 'mdi mdi-account-multiple menu-icon',
            ],
            'role-list' => [
                'title' => 'Role',
                'routeName' => 'role.index',
                'icon' => 'mdi mdi-account-settings menu-icon',
            ],
            'permission-list' => [
                'title' => 'Permission',
                'routeName' => 'permission.index',
                'icon' => 'mdi mdi-account-settings menu-icon',
            ],
            // 'master-group' => [
            //     'title' => 'Master Group',
            //     'routeName' => 'master-groups.index',
            //     'icon' => 'mdi mdi-flag menu-icon',
            // ],
            'room-list' => [
                'title' => 'Room',
                'routeName' => 'room.index',
                'icon' => 'mdi mdi-account-multiple menu-icon',
            ],
            'setting-list' => [
                'title' => 'Setting',
                'routeName' => 'settings.index',
                'icon' => 'mdi mdi-account-settings menu-icon',
            ],
        ]
    ],
    // 'user' => [
    //     'title' => 'User',
    //     'routeName' => 'user.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-account-multiple menu-icon',
    // ],
    // 'role' => [
    //     'title' => 'Role',
    //     'routeName' => 'role.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-account-settings menu-icon',
    // ],
    // 'permission' => [
    //     'title' => 'Permission',
    //     'routeName' => 'permission.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-account-key menu-icon',
    //        'sub_menu' => [
    //            'User' => [
    //                'title' => 'Users',
    //                'routeName' => 'user.index',
    //                'icon' => 'mdi mdi-account-multiple menu-icon',
    //            ],
    //            'roles' => [
    //                'title' => 'Role',
    //                'routeName' => 'role.index',
    //                'icon' => 'mdi mdi-account-settings menu-icon',
    //            ],
    //            'permission' => [
    //                'title' => 'Permission',
    //                'routeName' => 'permission.index',
    //                'icon' => 'mdi mdi-account-key menu-icon',
    //            ],
    //        ]
    // ],
    // 'setting' => [
    //     'title' => 'Setting',
    //     'routeName' => 'settings.index',
    //     'additional_query' => '',
    //     'icon' => 'mdi mdi-settings menu-icon',
    // ],
];
