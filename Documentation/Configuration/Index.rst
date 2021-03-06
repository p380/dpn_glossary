﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _configuration:

Configuration Reference
=======================

The whole linking of terms can be configured over TypoScript.
The Parsing itself can also be defined as precise as you wish.

There are also example styles and scripts for the views and a tiny CSS3 Tooltip

+ CSS: EXT:dpn_glossary/Resources/Public/css/styles.min.css
+ JS:  EXT:dpn_glossary/Resources/Public/js/scripts.min.js

Special: RealUrl
^^^^^^^^^^^^^^^^

An example configuration will be added to realurl by hook.

+ Add the id of your list & detailpage as the key (see example below).

::

    'fixedPostVars' => array(
	    'LISTPAGEUID' => 'dpn_glossary_list_RealUrlConfig',
	    'DETAILPAGEUID' => 'dpn_glossary_detail_RealUrlConfig',
    ),

Special: Umlauts
^^^^^^^^^^^^^^^^

If you want to add umlauts to the pagination you have to check the terms table collation.

+ Normal utf8 will not differ between Ä and A, you have to use "utf8_german2_ci" which would make a difference
+ You could change the 'name' column collation and add Ä,Ö,Ü to the comma list over typoscript
+ See `MySQL reference <http://dev.mysql.com/doc/refman/5.7/en/charset-collation-effect.html>`_ for more info

Extension Settings
------------------

.. toctree::
    :maxdepth: 1
    :titlesonly:
    :glob:

    ExtensionSettings/Index
    ExampleTypoScriptSetup/Index
