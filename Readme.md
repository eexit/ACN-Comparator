ACN Comparator
===

As part as one of our Uni project, my colleague and I had to develop a small application to compare OCR rendered files from an image database. While most of all classmate wrote their application in Java (or C++), we chose to write in PHP to show them that PHP-CLI could get the job done as well and why not very stylish.

Requirements
---
- PHP-CLI 5.3.*
- PHP 5.3 languages skills
- Symfony2 basis

Application structure
---
    Projet
    ├── Bases
    │   ├── Base1
    │   │   └── ocr
    │   ├── Base2
    │   │   └── ocr
    │   ├── Base3
    │   │   └── ocr
    │   ├── Base4
    │   │   └── ocr
    │   ├── Base5
    │   │   └── ocr
    │   ├── Base6
    │   │   └── ocr
    │   ├── Base7
    │   │   ├── Texte_B7_NG150.tiff
    │   │   ├── Texte_B7_NG200.tiff
    │   │   ├── Texte_B7_NG300.tiff
    │   │   ├── Texte_B7_NG600.tiff
    │   │   ├── Texte_B7_NG72.tiff
    │   │   └── ocr
    │   │       ├── Texte_B7_NG150
    │   │       ├── Texte_B7_NG200
    │   │       ├── Texte_B7_NG300
    │   │       ├── Texte_B7_NG600
    │   │       └── Texte_B7_NG72
    │   ├── Base8
    │   │   └── ocr
    │   └── Base9
    │       └── ocr
    └── Comparator
        ├── Icone
        │   └── Acn
        │       ├── Acn.php
        │       └── Exception.php
        ├── Readme.md
        ├── Symfony/
        └── app
            ├── Image_VT
            ├── app.php
            └── bootstrap.php
        
Launch the application
---

    % cd Projet/Comparator/app && php app.php

Informations
---
Joris Berthelot <joris.berthelot@gmail.com>
Chama Laatik <chama.laatik@gmail.com>
Copyright (c) 2011, Joris Berthelot