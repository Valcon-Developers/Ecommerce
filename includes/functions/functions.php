<?php

function getTitle()
{

  global $pageTitle;

  if (isset($pageTitle)) {
    echo $pageTitle;
  } else {
    echo "Defult";
  }

}
;


function getYoutubeEmbedID($url)
{
  // حذف كل شيء بعد علامة & (لو فيه باراميترات إضافية)
  $url = trim($url);

  // أنماط ممكنة لروابط يوتيوب
  $patterns = [
    '/youtu\.be\/([^\?\&]+)/', // لينك مختصر youtu.be/ID
    '/youtube\.com\/watch\?v=([^\&]+)/', // youtube.com/watch?v=ID
    '/youtube\.com\/embed\/([^\?\&]+)/', // youtube.com/embed/ID
    '/youtube\.com\/shorts\/([^\?\&]+)/', // youtube.com/shorts/ID
  ];

  foreach ($patterns as $pattern) {
    if (preg_match($pattern, $url, $matches)) {
      return $matches[1]; // ID الفيديو
    }
  }

  // لو مافيش تطابق، ترجع false أو قيمة فارغة
  return false;
}
