<ul>
    <li>
        <a

        <?php if( 
               $slug == 'projects' 
            || $slug == 'moon-bear-rescue' 
            || $slug == 'african-painted-dogs' 
            || $slug == 'cheetahs' 
            || $slug == 'pink-dolphin-rescue' 
            || $slug == 'coral-climate-change' ) : ?> 
            
            class="active" 
        
        <?php endif; ?>

        href="/projects" 
        title="Projects">
            Projects
        </a>
        
        <ul class="sub">
            <li><a href="/projects/moon-bear-rescue" title="Moon Bear Rescue">Moon Bear Rescue</a></li>
            <li><a href="/projects/african-painted-dogs" title="African Painted Dogs">African Painted Dogs</a></li>
            <li><a href="/projects/cheetahs" title="Cheetahs">Cheetahs</a></li>
            <li><a href="/projects/pink-dolphin-rescue" title="Pink Dolphin Rescue">Pink Dolphin Rescue</a></li>
            <li><a href="/projects/coral-climate-change" title="Coral Climate Change">Coral Climate Change</a></li>
        </ul>
    </li>
    <li>
        <a <?php if($slug == 'videos' ) : ?> class="active" <?php endif; ?> href="/videos" title="Videos">Videos</a>
    </li>
    <li>
        <a <?php if($slug == 'characters' ) : ?> class="active" <?php endif; ?> href="/characters" title="Characters">Characters</a>
    </li>
    <li>
        <a <?php if($slug == 'about' ) : ?> class="active" <?php endif; ?> href="/about" title="About">About</a>
    </li>
    <li>
        <a <?php if($slug == 'contact' ) : ?> class="active" <?php endif; ?> href="/contact" title="Contact">Contact</a>
    </li>
    <li class="donate">
        <a <?php if($slug == 'donate' ) : ?> class="active" <?php endif; ?> href="/donate" title="Donate"><img class="rounded" src="<?php echo get_template_directory_uri(); ?>/images/btn-donate.svg" alt="Donote to Endangered Species Revenge"></a>
    </li>
</ul>