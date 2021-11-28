<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Manager\UsersManager;
use App\Repository\UsersRepository;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class UsersCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    /**
     * @Route(path="/admin_dash/user/remove", name="remove_user")
     * @param Request $request
     * @param UsersManager $userManager
     */
    public function removeUser(Request $request, UsersManager $usersManager)
    {
        $id = $request->query->get('id');

        $usersManager->remove($id);

        return $this->redirectToRoute('admin', [
            'crudAction' => 'index',
            'entity' => $request->query->get('entity')
        ]);
    }

    /**
     * @Route(path="/admin_dash/users/statistic", name="statistic")
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @return Response
     */
    public function statistic(Request $request, UsersRepository $usersRepository)
    {
        $id = $request->query->get('id');
        $users = $usersRepository->find($id);

        $counterView = [];
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

        foreach ($days as $day) {
            array_push($counterView, random_int(1, 10));
        }

        return $this->render('bundles/EasyAdminBundle/statistics_user.html.twig', [
            'users' => $users,
            'crudAction' => 'index',
            'counterView' => $counterView,
            'dataName' => $days
        ]);
    }

    public function configureActions(Actions $actions): Actions
    {


        $detailUser = Action::new('detailUser', 'Detail', 'fa fa-user')
            ->linkToCrudAction(Crud::PAGE_DETAIL)
            ->addCssClass('btn btn-info');

        $removeUser = Action::new('removeUser', 'Supprimer User', 'fa fa-trash')
            ->addCssClass('btn btn-danger')
            ->linkToRoute('remove_user', function (Users $entity) {
                return [
                    'id' => $entity->getId()
                ];
            });

        $statistic = Action::new('statistic', 'Stat User', 'fa fa-user')
            ->addCssClass('btn btn-primary')
            ->linkToRoute('statistic', function (Users $entity) {
                return [
                    'id' => $entity->getId()
                ];
            });

        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->disable(Action::DELETE)
            ->add(Crud::PAGE_INDEX, $detailUser)
            ->add(Crud::PAGE_INDEX, $removeUser)
            ->add(Crud::PAGE_INDEX, $statistic);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);

        $this->messageService->addSuccess('Votre User à bien été modifier .');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            TextField::new('password')->onlyOnForms(),
            TextField::new('service')
        ];
    }
}
