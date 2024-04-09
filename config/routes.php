<?php

// main pages
$router->get("/", "indexController");
$router->get("/storytelling", "storytellingController");
$router->get("/map", "mapController");
$router->get("/virtual-tour", "virtualTourController");
$router->get("/calendar", "calendarController");
$router->get("/blog", "blogController");
$router->get("/aboutus", "aboutusController");
$router->get("/dashboard", "adminDashboardController");
$router->get("/credits", "creditsController");

// sights
$router->get("/tvrdjava", "sights/tvrdjavaController");
$router->get("/manastir", "sights/manastirController");
$router->get("/samostan", "sights/samostanController");
$router->get("/tursko-kupatilo", "sights/kupatiloController");
$router->get("/siljak", "sights/siljakController");

// auth
$router->get("/login", "auth/loginFormController");
$router->post("/login", "auth/loginLogicController");
$router->get("/logout", "auth/logoutController");
$router->get("/register", "auth/registerFormController");
$router->post("/register", "auth/registerLogicController");
$router->get("/dashboard/users", "auth/usersCMSController");
$router->delete("/dashboard/users/delete", "auth/deleteUserController");

//posts
$router->get("/post", "posts/postController");
$router->get("/dashboard/posts", "posts/postsCMSController");
$router->get("/dashboard/posts/create", "posts/createPostFormController");
$router->post("/dashboard/posts/create", "posts/createPostLogicController");
$router->delete("/dashboard/posts/delete", "posts/deletePostController");
$router->get("/dashboard/posts/update", "posts/updatePostFormController");
$router->patch("/dashboard/posts/update", "posts/updatePostLogicController");

// events
$router->get("/event", "events/eventController");
$router->get("/dashboard/events", "events/eventsCMSController");
$router->get("/dashboard/events/create", "events/createEventFormController");
$router->post("/dashboard/events/create", "events/createEventLogicController");
$router->delete("/dashboard/events/delete", "events/deleteEventController");
$router->get("/dashboard/events/update", "events/updateEventFormController");
$router->patch("/dashboard/events/update", "events/updateEventLogicController");

//producers
$router->get("/dashboard/producers", "producers/producersCMSController");
$router->get("/dashboard/producers/create", "producers/createProducerFormController");
$router->post("/dashboard/producers/create", "producers/createProducerLogicController");
$router->delete("/dashboard/producers/delete", "producers/deleteProducerController");
$router->get("/dashboard/producers/update", "producers/updateProducerFormController");
$router->patch("/dashboard/producers/update", "producers/updateProducerLogicController");
$router->post("/map/add-comment", "producers/addCommentController");

//products
$router->get("/dashboard/products", "products/productsCMSController");
$router->get("/dashboard/products/create", "products/createProductFormController");
$router->post("/dashboard/products/create", "products/createProductLogicController");
$router->delete("/dashboard/products/delete", "products/deleteProductController");
$router->get("/dashboard/products/update", "products/updateProductFormController");
$router->patch("/dashboard/products/update", "products/updateProductLogicController");

$router->get("/products/order", "products/orderProductFormController");
$router->post("/products/order", "products/orderProductLogicController");
$router->get("/products/order/made", "products/orderMadeController");

//team

$router->get("/team/Milan", "team/milanController");
$router->get("/team/Zorica", "team/zoricaController");
$router->get("/team/Stela", "team/stelaController");
$router->get("/team/Branka", "team/brankaController");


// errors
$router->get("/error404", "error/404");
$router->get("/error500", "error/500");
$router->get("/error400", "error/400");
