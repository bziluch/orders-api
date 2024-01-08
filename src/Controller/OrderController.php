<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderedProduct;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/order', name: 'api_order_')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'new', methods:['post'] )]
    public function new(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Request $request
    ) : JsonResponse
    {
        $requestBody = json_decode($request->getContent(), true);
        if (!array_key_exists('products', $requestBody)) {
            return new JsonResponse([
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Invalid request body'
            ], Response::HTTP_BAD_REQUEST);
        }
        $order = new Order();
        foreach ($requestBody['products'] as $requestProduct) {
            $product = $requestProduct['id'] > 0 ? $productRepository->find($requestProduct['id']) : null;
            if (!$product) {
                return new JsonResponse([
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Invalid id of product #'.$requestProduct['id'].' - product does not exist'
                ], Response::HTTP_BAD_REQUEST);
            }
            if (!($requestProduct['quantity'] > 0)) {
                return new JsonResponse([
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Invalid quantity of product #'.$requestProduct['id']
                ], Response::HTTP_BAD_REQUEST);
            }
            $orderedProduct = (new OrderedProduct())
                ->setQuantity($requestProduct['quantity'])
                ->setProduct($product)
                ->setOrder($order);
            $order->addOrderedProduct($orderedProduct);
        }
        $entityManager->persist($order);
        $entityManager->flush();

        return new JsonResponse([
            'code' => Response::HTTP_OK,
            'order' => $serializer->normalize($order, 'json', ['groups' => 'order'])
        ], Response::HTTP_OK);
    }
}