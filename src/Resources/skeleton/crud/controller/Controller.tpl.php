<?= "<?php\n" ?>

namespace <?= $namespace ?>;

use <?= $interface_full_class_name ?>;
use <?= $form_full_class_name ?>;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\<?= $parent_class_name ?>;
use App\Logic\ClassResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

<?php if ($use_attributes) { ?>
#[Route('<?= $route_path ?>')]
<?php } else { ?>
/**
 * @Route("<?= $route_path ?>")
 */
<?php } ?>
class <?= $class_name ?> extends <?= $parent_class_name; ?><?= "\n" ?>
{


    private EntityManagerInterface $entityManager;
    
    
    public function __construct( EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

<?= $generator->generateRouteForControllerMethod('/', sprintf('%s_index', $route_name), ['GET']) ?>
    public function index(): Response
    {
        return $this->render('<?= $templates_path ?>/index.html.twig', [
            '<?= $entity_twig_var_plural ?>' => $this->entityManager->getRepository( <?= $interface_class_name ?>::class )->findAll(),
        ]);
    }

<?= $generator->generateRouteForControllerMethod('/new', sprintf('%s_new', $route_name), ['GET', 'POST']) ?>
    public function new(Request $request, ClassResolver $classResolver): Response
    {
        /** @var <?=$interface_class_name ?> $<?= $entity_var_singular ?> */
        $<?= $entity_var_singular ?> = $classResolver->getObjectByInterfaceName( <?= $interface_class_name ?>::class );

        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($<?= $entity_var_singular ?>);
            $this->entityManager->flush();

            return $this->redirectToRoute('<?= $route_name ?>_index', [], Response::HTTP_SEE_OTHER);
        }

<?php if ($use_render_form) { ?>
        return $this->renderForm('<?= $templates_path ?>/new.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form,
        ]);
<?php } else { ?>
        return $this->render('<?= $templates_path ?>/new.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
        ]);
<?php } ?>
    }

<?= $generator->generateRouteForControllerMethod(sprintf('/{%s}', $entity_identifier), sprintf('%s_show', $route_name), ['GET']) ?>
    public function show(int $<?= $entity_identifier ?>): Response
    {
        $<?= $entity_var_singular ?> = $this->entityManager->find( <?= $interface_class_name ?>::class, $id );

        return $this->render('<?= $templates_path ?>/show.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
        ]);
    }

<?= $generator->generateRouteForControllerMethod(sprintf('/{%s}/edit', $entity_identifier), sprintf('%s_edit', $route_name), ['GET', 'POST']) ?>
    public function edit(Request $request, int $<?= $entity_identifier ?>): Response
    {
        $<?= $entity_var_singular ?> = $this->entityManager->find( <?= $interface_class_name ?>::class, $id );

        $form = $this->createForm(<?= $form_class_name ?>::class, $<?= $entity_var_singular ?>);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('<?= $route_name ?>_index', [], Response::HTTP_SEE_OTHER);
        }

<?php if ($use_render_form) { ?>
        return $this->renderForm('<?= $templates_path ?>/edit.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form,
        ]);
<?php } else { ?>
        return $this->render('<?= $templates_path ?>/edit.html.twig', [
            '<?= $entity_twig_var_singular ?>' => $<?= $entity_var_singular ?>,
            'form' => $form->createView(),
        ]);
<?php } ?>
    }

<?= $generator->generateRouteForControllerMethod(sprintf('/{%s}', $entity_identifier), sprintf('%s_delete', $route_name), ['POST']) ?>
    public function delete(Request $request, int $<?= $entity_identifier ?>): Response
    {
        $<?= $entity_var_singular ?> = $this->entityManager->find( <?= $interface_class_name ?>::class, $id );

        if ($this->isCsrfTokenValid('delete'.$<?= $entity_var_singular ?>->get<?= ucfirst($entity_identifier) ?>(), $request->request->get('_token'))) {
            $this->entityManager->remove($<?= $entity_var_singular ?>);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('<?= $route_name ?>_index', [], Response::HTTP_SEE_OTHER);
    }
}
