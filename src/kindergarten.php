<?php
namespace Gregorhyneck\Kindergarten;

use simplehtmldom\HtmlWeb;
require '../vendor/autoload.php';  // Load via Composer

$url = 'https://sonnenschein-regentroepfchen.de/interessentenanfrage';
$dom = new HtmlWeb();
$html = $dom->load($url);

function prependNode($html, $labelSelector, $nthLabelSelector, $nodeToPrepend) {
    $inputElementNode = $html->find($labelSelector, $nthLabelSelector)->parentNode();
    $inputElementNode->outertext = $nodeToPrepend . $inputElementNode->outertext;
}

function createHeading($html, $headingContent, $insertBeforeThisLabel, $nthLabel) {
    $headingContainer = $html->createElement('div');
    $headingContainer->setAttribute('data-mve-font-change', 0);
    $headingContainer->setAttribute('class', 'styles_contentContainer__lrPIa textnormal styles_text__3jGMu');

    $headingNode = $html->createElement('h3');
    $headingNode->addClass('textheading3 mobile-oversized');

    $headingNode->innertext = $headingContent;
    $headingContainer->appendChild($headingNode);

    prependNode($html, $insertBeforeThisLabel, $nthLabel, $headingContainer);
}

createHeading($html,'Angaben über das Kind', '[data-label="Name"]', 0);
createHeading($html,'Person 1', '[data-label="Name"]', 1);
createHeading($html,'Angaben über die Personensorgeberechtigten', '[data-label="Name"]', 1);
createHeading($html,'Person 2', '[data-label="Name"]', 2);
createHeading($html,'Geschwister', '[data-label="Geschwister (Name und Geburtsdatum)"]', 0);

$styles = $html->createTextNode('<style type="text/css">
        .contact-form-text-style-div:has(+ .contactFormResponseStatus.formSuccess) {
            display: none;
        }
        .Preview_row__3Fkye.row:has(.contactFormResponseStatus.formSuccess),
        .Preview_componentWrapper__2i4QI:has(.contactFormResponseStatus.formSuccess),
        .StripPreview_backgroundComponent__3YmQM.Background_backgroundComponent__3_1Ea:has(.contactFormResponseStatus.formSuccess),
        .Preview_row__3Fkye.row:has(.contactFormResponseStatus.formSuccess),
        .Preview_componentWrapper__2i4QI:has(.contactFormResponseStatus.formSuccess) {
            min-height: 0 !important;
        }
        .contactFormResponseStatus.formSuccess {
            font-family:Montserrat,Open Sans,Helvetica Neue,Helvetica,"sans-serif";
            font-style:normal;
            font-size:30px;
            font-weight:400;
            text-decoration:none;
            color:#55b650;
            letter-spacing:normal;
            line-height:1.2
        }
    </style>');

$head = $html->find('head', 0);
$head->appendChild($styles);


file_put_contents('interessentenanfrage.html', $html);