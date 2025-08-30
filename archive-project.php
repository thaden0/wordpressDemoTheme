<?php get_header(); ?>
<main class="wrap">
  <header class="page-header">
    <h1><?php post_type_archive_title(); ?></h1>
  </header>

  <?php if (have_posts()): ?>
    <section class="posts">
      <?php while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <h3>
            <?php echo esc_html( get_post_meta( get_the_ID(), 'project_name', true ) ); ?>
          </h3>

          <div class="meta">
            <?php
              $start = get_post_meta( get_the_ID(), 'start_date', true );
              $end   = get_post_meta( get_the_ID(), 'end_date', true );
              $url   = get_post_meta( get_the_ID(), 'url', true );
            ?>
            <?php if ($start): ?>
              <div>
                <span class="bold">Start:</span>
                <span><?php echo esc_html($start); ?></span>
              </div>
            <?php endif; ?>
            <?php if ($end): ?>
              <div>
                <span class="bold">End:</span>
                <span><?php echo esc_html($end); ?></span>
              </div>
              <?php endif; ?>
            <?php if ($url): ?>
              <div>
                <span class="bold">URL:</span>
                <span><a href="<?php echo esc_url($url); ?>">
                <?php echo esc_html($url); ?></a></span>
              </div>
            <?php endif; ?>
          </div>

          <div class="excerpt"><?php the_excerpt(); ?></div>
        </article>
      <?php endwhile; ?>
    </section>

    <nav class="pagination">
      <?php the_posts_pagination(); ?>
    </nav>
  <?php else: ?>
    <p>No projects found.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
