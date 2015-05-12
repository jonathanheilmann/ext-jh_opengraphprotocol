.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


ChangeLog
---------

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :Version:
         Version

   :Changes:
         Changes

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


