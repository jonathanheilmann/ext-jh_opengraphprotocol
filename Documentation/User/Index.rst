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
         If `crawlParents.image` is enabled in extension manager, jh_opengraphprotocol crawls the page rootline until
         an image is found or root is reached.
         While crawling jh_opengraphprotocol image field is preferred to page's media field.
         \
         If `crawlParents.image` is NOT enabled:
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
