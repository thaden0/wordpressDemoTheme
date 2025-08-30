<?php get_header(); ?>
<main class="wrap">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>      
      <h1><?php the_title(); ?></h1>
      <h2><?php echo get_post_meta($post->ID,'project_name',true); ?></h2>

      <div class="project-meta">
        <div>
          <span class="bold">Start Date: </span>
          <span><?php echo get_post_meta($post->ID,'start_date',true); ?></span>
        </div>
        <div>
          <span class="bold">End Date: </span>
          <span><?php echo get_post_meta($post->ID,'end_date',true); ?></span>
        </div>
        <div>
          <span class="bold">URL: </span>
          <a href="<?php echo get_post_meta($post->ID,'url',true); ?>"><?php echo get_post_meta($post->ID,'url',true); ?></a>
        </div>
      </div>
      
      <div class="content"><?php the_content(); ?></div>
    </article>
  <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
