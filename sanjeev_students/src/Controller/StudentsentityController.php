<?php

namespace Drupal\sanjeev_students\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\sanjeev_students\Entity\StudentsentityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class StudentsentityController.
 *
 *  Returns responses for Studentsentity routes.
 */
class StudentsentityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Studentsentity revision.
   *
   * @param int $studentsentity_revision
   *   The Studentsentity revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($studentsentity_revision) {
    $studentsentity = $this->entityTypeManager()->getStorage('studentsentity')
      ->loadRevision($studentsentity_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('studentsentity');

    return $view_builder->view($studentsentity);
  }

  /**
   * Page title callback for a Studentsentity revision.
   *
   * @param int $studentsentity_revision
   *   The Studentsentity revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($studentsentity_revision) {
    $studentsentity = $this->entityTypeManager()->getStorage('studentsentity')
      ->loadRevision($studentsentity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $studentsentity->label(),
      '%date' => $this->dateFormatter->format($studentsentity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Studentsentity.
   *
   * @param \Drupal\sanjeev_students\Entity\StudentsentityInterface $studentsentity
   *   A Studentsentity object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(StudentsentityInterface $studentsentity) {
    $account = $this->currentUser();
    $studentsentity_storage = $this->entityTypeManager()->getStorage('studentsentity');

    $langcode = $studentsentity->language()->getId();
    $langname = $studentsentity->language()->getName();
    $languages = $studentsentity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $studentsentity->label()]) : $this->t('Revisions for %title', ['%title' => $studentsentity->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all studentsentity revisions") || $account->hasPermission('administer studentsentity entities')));
    $delete_permission = (($account->hasPermission("delete all studentsentity revisions") || $account->hasPermission('administer studentsentity entities')));

    $rows = [];

    $vids = $studentsentity_storage->revisionIds($studentsentity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\sanjeev_students\Entity\StudentsentityInterface $revision */
      $revision = $studentsentity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $studentsentity->getRevisionId()) {
          $link = Link::fromTextAndUrl($date, new Url('entity.studentsentity.revision', [
            'studentsentity' => $studentsentity->id(),
            'studentsentity_revision' => $vid,
          ]))->toString();
        }
        else {
          $link = $studentsentity->toLink($date)->toString();
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.studentsentity.translation_revert', [
                'studentsentity' => $studentsentity->id(),
                'studentsentity_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.studentsentity.revision_revert', [
                'studentsentity' => $studentsentity->id(),
                'studentsentity_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.studentsentity.revision_delete', [
                'studentsentity' => $studentsentity->id(),
                'studentsentity_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['studentsentity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
