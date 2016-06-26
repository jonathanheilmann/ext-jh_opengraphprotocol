.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _changelog:

ChangeLog
=========

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Version:
         Version

   :Changes:
         Changes

 - :Version:
         1.2.0

   :Changes:
         \* [TASK]                  Update documentation

         \* [ENHANCEMENT]   #30     Add image details (size, mime)

         \* [ENHANCEMENT]   #29     Conflicts with news 3.2.4 (Skip tx_jhopengraphprotocol for single news view, as EXT:news adds dedicated og-properties)

         \* [ENHANCEMENT]   #26     Add composer.json

         \* [ENHANCEMENT]   #25     Overwrite tags from extbase

 - :Version:
         1.1.1

   :Changes:
         \* [BUGFIX]        #16     Can't use method return value in write context

         \* [ENHANCEMENT]   #18     max character limit of the OG:description tag

         \* [TASK]          #19     Update copyright year to 2016

         \* [TASK]          #20     Implement PSR-2 standard

         \* [BUGFIX]        #21     Wrong closing tag in template

 - :Version:
         1.1.0

   :Changes:
         \* Removed support for TYPO3 CMS 4.5-6.1

         \* Added support for TYPO3 CMS 7.x

         \* Use FAL for image-relations (Please see :ref:`admin-updating-toversion110` for updating)

         \* Wrong local output (replace '-' by '_', remove charset)

         \* Add newline after each tag

         \* Rewritten documentation

 - :Version:
         1.0.4

   :Changes:
         \* Fixed TYPO3 forge bug #66993 and #67231

         \* Still support for TYPO3 CMS 4.5-6.1

 - :Version:
         1.0.3

   :Changes:
         \* Added htmlentities() to some more og-properties

         \* Last version to support TYPO3 CMS 4.5-6.1

 - :Version:
         1.0.2

   :Changes:
         \* Security fix, please update

 - :Version:
         1.0.1

   :Changes:
         \* fixed bug #56813

         \* updated manual to ReST


 - :Version:
         1.0.0

   :Changes:
         \* added support for TYPO3 CMS 6.2

         \* introduced some breaking changes (see manual)

         \* rewritten manual


 - :Version:
         0.3.0

   :Changes:
         \* moved constants from category 'jh\_opengraphprotocol' to
         'plugin.jh\_opengraphprotocol'

         \* try to use page-description if there is no local description

         \* moved local page-settings to an own tab

         \* updated manual


 - :Version:
         0.2.2

   :Changes:
         \* fixed a bug that crashed the localconf


 - :Version:
         0.2.1

   :Changes:
         \* fixed a bug in multilanguage support (alternative language has not
         been displayed)


 - :Version:
         0.2.0

   :Changes:
         \* added support for multilanguage pages


 - :Version:
         0.1.1

   :Changes:
         \* plugin.jh\_opengraphprotocol.image supports the EXT: prefix now

         \* og:image is now forced to be prepended with a scheme and host


 - :Version:
         0.1.0

   :Changes:
         \* uses the new hook of EXT:jh\_opengraph\_ttnews to prevent from two
         og:tag groups (thanks to Bernhard Kraft)

         \* set extension-state to stable

         \* added dependency to TYPO3 CMS

         \* added conflict with EXT:jh\_opengraph\_ttnews < 0.0.10

         \* updated manual


 - :Version:
         0.0.7

   :Changes:
         \* bugfix: when using EXT:jh\_opengraph\_ttnews the og:tags has been
         displayed twice - one from jh\_opengraphprotocol and one from
         jh\_opengraph\_ttnews now, jh\_opengraphprotocol renders no output if
         there is a tt\_news single view


 - :Version:
         0.0.6

   :Changes:
         \* Variable $extKey was not defined, what made the
         additionalHeaderData array use the standard 1,2,3... numbers instead
         of the full string for keys.


 - :Version:
         0.0.5

   :Changes:
         \* bugfix (constant.txt is now saved as an ANSI encoded file)


 - :Version:
         0.0.4

   :Changes:
         \* bugfixes

         \* now compatible with CoolURI

         \* set extension-state to beta


 - :Version:
         0.0.3

   :Changes:
         \* beauty-related fixes


 - :Version:
         0.0.2

   :Changes:
         \* optimized html output

         \* bugfixes

         \* added icon

         \* added manual


 - :Version:
         0.0.1

   :Changes:
         \* Initial release


.. ###### END~OF~TABLE ######
