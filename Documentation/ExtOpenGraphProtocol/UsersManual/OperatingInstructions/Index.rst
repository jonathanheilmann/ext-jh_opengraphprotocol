

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


Operating Instructions
^^^^^^^^^^^^^^^^^^^^^^

The content of each Open Graph property is taken by this priority:

.. ### BEGIN~OF~TABLE ###

.. t3-field-list-table::
 :header-rows: 1

 - :property:
         Property

   :first:
         first

   :second:
         second

   :third:
         third

 - :property:
         **title**

   :first:
         local

   :second:
         page-title

   :third:
         \

 - :property:
         **title (template “Open Graph protocol v0.3.0”)**

   :first:
         local

   :second:
         global

   :third:
         page-title

 - :property:
         **type**

   :first:
         local

   :second:
         global

   :third:
         \

 - :property:
         **image**

   :first:
         local

   :second:
         global

   :third:
         \

 - :property:
         **site\_name**

   :first:
         global

   :second:
         template-sitetitle

   :third:
         \

 - :property:
         **description**

   :first:
         local

   :second:
         page-properties

   :third:
         global

 - :property:
         **url**

   :first:
         generated

   :second:
         \

   :third:
         \

 - :property:
         **locale (NOT for template “Open Graph protocol v0.3.0”)**

   :first:
         generated from config.locale\_all if available

   :second:
         \

   :third:
         \


.. ###### END~OF~TABLE ######

For example the extension tries to render the image-property:If there
is no image defined local within the page-properties, if tries to
fetch a image from the global TypoScript Settings. If there is no
image, too, no image property will be rendered.

