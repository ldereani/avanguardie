<?php
global $post;

?>
<nav style="background-color:#ffffff;z-index:1;top:0px;display:flex;font-family:-apple-system, BlinkMacSystemFont, sans-serif;justify-content:flex-end;position:sticky;align-items:center;text-overflow:ellipsis;box-sizing:border-box;border-bottom:1px solid rgba(0, 0, 0, 0.07);height:50px;">
<input id="menuToggle" type="checkbox" style="display:none;">

<label id="menuButton" for="menuToggle">
<div id="menuButtonIcon" style="padding:8px;width:24px;">
<svg viewBox="0 0 24.0 24.0" preserveAspectRatio="none">
<path d="M5.75 5.25h12.5a.75.75 0 1 1 0 1.5H5.75a.75.75 0 0 1 0-1.5zm0 6h12.5a.75.75 0 1 1 0 1.5H5.75a.75.75 0 1 1 0-1.5zm0 6h12.5a.75.75 0 1 1 0 1.5H5.75a.75.75 0 1 1 0-1.5z">
</path>
</svg>
</div>
</label>
<ul id="verticalMenu">
<li class="navMenuLink"><a class="navMenuLinkContent" href="#home">Home</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#about">Chi siamo</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#details">Il Manifesto</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#activities">Attivit&agrave;</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#rsvp">Contatti</a></li>
</ul>
<ul id="horizontalMenu" style="padding:0;margin:0;">
<li class="navMenuLink"><a class="navMenuLinkContent" href="#home">Home</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#about">Chi siamo</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#details">Il Manifesto</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#activities">Attivit&agrave;</a></li>
<li class="navMenuLink"><a class="navMenuLinkContent" href="#rsvp">Contatti</a></li>
</ul>
</nav>
<?php
