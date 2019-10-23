<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var \year\gii\models\generators\gomodel\Generator $generator
 * @var string $tableName full table name
 * @var string $className class name for table
 */

//   $generator->tableName
$goColumnsMeta = $generator->columnsMetaData($giiConsolePath) ;

$packageName = 'handlers';
$imports = [] ;

$modelClassName = $modelName = $className ;
$daoName = lcfirst($className).'DAO' ;
$serviceName = lcfirst($className).'Service' ;
$controllerName = lcfirst($className.'Controller') ;

// url path pattern:
$urlBase =  Inflector::camel2id($modelName);
$getUrlPattern = $urlBase .'/{id:[0-9]+}' ;
$queryUrlPattern = $urlBase   ;
$createUrlPattern = $urlBase   ;
$updateUrlPattern = $urlBase .'/{id}'  ;
$deleteUrlPattern = $urlBase .'/{id}'  ;

$daoOrServiceName = $generator->enableServiceLayer? $serviceName : $daoName ;
$daoOrServiceVar = $generator->enableServiceLayer? 'service' : 'dao' ;
?>
package handlers

import (
	"dbstair/apps/giisample/models"
	"github.com/gorilla/mux"
	"log"
	"net/http"
)

type (
	// <?= $daoName ?> specifies the interface for the <?= $tableName ?> service needed by <?= lcfirst($controllerName) ?>.

<?php if($generator->enableServiceLayer ): ?>
    <?= lcfirst($serviceName) ?> interface {
        // NOT IMPLEMENTED  YET
    }

    // <?= $controllerName ?> defines the handlers for the CRUD APIs.
    <?= $controllerName ?>  struct {
        service <?= lcfirst($serviceName)  ?>
    }
<?php else: ?>
    <?= lcfirst($daoName) ?> interface {
    Get(id int) (*models.<?= $className ?>, error)
    Query(sm *models.<?= $className ?>, offset, limit int,  sort ...string) ([]models.<?= $className ?>, error)
    Count(sm *models.<?= $className ?>) (int, error)

    Create(model *models.<?= $className ?>)  error
    Update(id int, model *models.<?= $className ?>)  error
    Delete(id int) error
    }

    // <?= $controllerName ?> defines the handlers for the CRUD APIs.
    <?= $controllerName ?>  struct {
        dao <?= lcfirst($daoName)  ,"\n"?>
    }
<?php endif; ?>

)

// Serve<?= Inflector::pluralize($className )?> sets up the routing of <?= $tableName ?> endpoints and the corresponding handlers.
func Serve<?= ucfirst($controllerName) ?>(r *mux.Router   , <?= $daoOrServiceVar?> <?= $daoOrServiceName ?>  ) {
	h := &<?= lcfirst($controllerName) ?>{  <?= $daoOrServiceVar ?>  }
	// r := mux.NewRouter()
	// Serve<?= Inflector::pluralize($className )?>  Register the handler functions
	r.HandleFunc("/<?= $getUrlPattern?>", h.get()).Methods("GET")        // Get model by id
	r.HandleFunc("/<?= $queryUrlPattern?>", h.query()).Methods("GET")                  // list models
	r.HandleFunc("/<?= $createUrlPattern?>", h.create()).Methods("POST")                // create model
	r.HandleFunc("/<?= $updateUrlPattern?>", h.update()).Methods("PUT", "POST")    // update model
	r.HandleFunc("/<?= $deleteUrlPattern?>", h.delete()).Methods("DELETE", "POST") // delete model
}

func (c *<?= lcfirst($controllerName) ?>) get() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
        idInt, err := strconv.Atoi(id)

        if err != nil {
          http.Error(w, errors.Wrap(err, "Atoi Error").Error(), http.StatusBadRequest)
        }

        m, err := c.<?= $daoOrServiceVar ?>.Get(idInt)

        if err != nil {
            webutil.NotFound(w)
            return
        }
        log.Printf("%#v", m)
        webutil.ServeJson(w,m)

        }
}

func (c *<?= lcfirst($controllerName) ?>) query() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		_, err := w.Write([]byte("list <?=  $tableName ?>!"))
        sm := models.<?= $className ?>{}
        decoder := schema.NewDecoder()
        if err := decoder.Decode(&sm, r.URL.Query()); err != nil {
             fmt.Println(err)
             return
        }
        log.Printf("%#v \n", sm)

        rs, err := c.<?= $daoOrServiceVar ?>.Query(sm,0, 100)
        if err != nil {
            http.Error(w, err.Error(), http.StatusInternalServerError)
        }
        webutil.ServeJson(w, rs)
	}
}

func (c *<?= lcfirst($controllerName) ?>) create() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		_, err := w.Write([]byte("create <?=  $tableName ?>!"))
		if err != nil {
			log.Println("update Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) update() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := w.Write([]byte("update <?=  $tableName ?>!" + id))
		if err != nil {
			log.Println("update Error:", err)
		}
	}
}

func (c *<?= lcfirst($controllerName) ?>) delete() http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		id := mux.Vars(r)["id"]
		_, err := w.Write([]byte("delete <?=  $tableName ?>!" + id))
		if err != nil {
			log.Println("delete Error:", err)
		}
	}
}
