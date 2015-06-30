.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt

.. _user-manual:

User Manual
===========

.. _user-operatingInstructions:

Operating Instructions
----------------------

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
         **image**

   :first:
         local

   :second:
         page-media

   :third:
         global

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
         **locale**

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
