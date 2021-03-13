<?php

/**

 *

 * Template Name: Pagebuilder

 *

 * The template for displaying content from pagebuilder.

 *

 * This is the template that displays pages without title in fullwidth layout. Suitable for use with Pagebuilder.

 *

 * @link https://codex.wordpress.org/Template_Hierarchy

 *

 * @package Flash

 */

require 'variables.php';

function print_form($website_url, $email_form_filepath) {
  return '
    <form id="" class="" method="post" action="' . $website_url . $email_form_filepath . '" >

              
      <div class="" style="display:flex;flex-direction:row;">
        <div style="display:flex;flex-direction:column;flex:auto">
          <label for="prenom" style="font-size:1.2em;">Prénom</label>
            <div class="">
                <input type="text" id="prenom" name="prenom" class="" required>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;flex:auto">
        <label for="nom" style="font-size:1.2em;">Nom</label>
            <div class="">
                <input type="text" id="nom" name="nom" class="" required>
            </div>
        </div>
      </div>

      <div class="">
          <label for="email" style="font-size:1.2em;">Email</label>
          <div class="">
              <input type="email" id="email" name="email" class="" required>
          </div>
      </div>

      <div class="">
          <label for="message" style="font-size:1.2em;">Message</label>
          <div class="">
              <textarea id="message" name="message" class="" rows="6" maxlength="3000" required></textarea>
          </div>
      </div>

      <div class="">
        <label for="newsletter" style="font-size:1.2em;">Je souhaite m\'inscrire à la newsletter</label>
        <input type="checkbox" id="newsletter" name="newsletter" value="newsletter_yes">
      </div>

      <br>

      <div class="">
          <button type="submit" id="" class="">Envoyer</button>
      </div>

    </form> 
  
  ';
}

$notification = $_GET['resultat'];

get_header(); ?>



	<?php

	/**

	 * flash_before_body_content hook

	 */

	do_action( 'flash_before_body_content' ); ?>



	<div id="primary" class="content-area pagebuilder-content">

		<main id="main" class="site-main" role="main">

      <?php the_content(); // Contenu de la page ajouté depuis l'éditeur Wordpress ?>

      <?php 
      
        if(!empty($notification)) {

          switch ($notification) {
            case "erreur_champ_vide":
              echo '<p class="custom-form-erreur">Tous les champs du formulaire doivent être remplis. Votre message n\'a pas pu être envoyé.</p>';
              break;
            case "erreur_email_invalide":
              echo '<p class="custom-form-erreur">L\'adresse email saisie n\'est pas valide. Votre message n\'a pas pu être envoyé.</p>';
              break;
            case "erreur_nom":
              echo '<p class="custom-form-erreur">Votre nom doit contenir au moins deux lettres et ne peut contenir que des lettres en majuscules ou minuscules. Votre message n\'a pas pu être envoyé.</p>';
              break;
            case "erreur_prenom":
              echo '<p class="custom-form-erreur">Votre prénom doit contenir au moins deux lettres ne peut contenir que des lettres en majuscules ou minuscules. Votre message n\'a pas pu être envoyé.</p>';
              break;
            case "erreur_lien":
              echo '<p class="custom-form-erreur">Ce formulaire n\'accepte pas les liens. Votre message n\'a pas pu être envoyé.</p>';
              break;
            case "ok":
              echo '<p class="custom-form-succes">Merci pour votre message, nous vous répondrons dès que possible.</p>';
              break;
          }
        }
      
      ?>

<? echo "lol" ?><br>

    <? echo print_form($website_url, $email_form_filepath); ?>




		</main><!-- #main -->

	</div><!-- #primary -->



	<?php

	/**

	 * flash_after_body_content hook

	 */

	do_action( 'flash_after_body_content' ); ?>



<?php

get_footer();

