<?php

namespace Spatie\TwitterStreamingApi;

use RWC\TwitterStream\Rule;
use RWC\TwitterStream\RuleBuilder;
use RWC\TwitterStream\Sets;
use RWC\TwitterStream\Support\Arr;
use RWC\TwitterStream\TwitterStream;

class PublicStream
{
    protected TwitterStream $stream;

    /** @var callable */
    protected $onTweet;
    protected RuleBuilder $rule;

    public function __construct(string $bearerToken, string $apiKey, string $apiSecretKey)
    {
        $this->stream = new TwitterStream($bearerToken, $apiKey, $apiSecretKey);
        $this->rule = RuleBuilder::create();
        $this->rule2 = RuleBuilder::create();
        $this->rule3 = RuleBuilder::create();
        $this->rule4 = RuleBuilder::create();
        $this->rule5 = RuleBuilder::create();
        $this->rule6 = RuleBuilder::create();
        $this->rule7 = RuleBuilder::create();
        $this->rule8 = RuleBuilder::create();
        $this->rule9 = RuleBuilder::create();
        $this->rule10 = RuleBuilder::create();
        $this->rule11 = RuleBuilder::create();
        $this->rule12 = RuleBuilder::create();
        $this->rule13 = RuleBuilder::create();
        $this->rule14 = RuleBuilder::create();
        $this->rule15 = RuleBuilder::create();
        $this->rule16 = RuleBuilder::create();
        $this->rule17 = RuleBuilder::create();
        $this->rule18 = RuleBuilder::create();
        $this->rule19 = RuleBuilder::create();
        $this->rule20 = RuleBuilder::create();
        $this->rule21 = RuleBuilder::create();
        $this->rule22 = RuleBuilder::create();
        $this->rule23 = RuleBuilder::create();
    }

    public static function create(string $bearerToken, string $apiKey, string $apiSecretKey): static
    {
        return new self($bearerToken, $apiKey, $apiSecretKey);
    }

    public function whenHears(string | array $listenFor, callable $whenHears): self
    {
        $this->rule->raw(array_reduce(Arr::wrap($listenFor), static function ($_, $listener) {
            if (empty($_)) {
                return $listener;
            }

            return $_ . ' OR ' . $listener;
        }));
		
		
		//Adding custom rules to cover more keywords
		$food2 = array('tomātu','jāēd','tējas','Dārzeņu','pankūkas','paēst','mērci','garšīga','ēdot',
						'kāpostu','mērce','rīsi','ābolu','kartupeļus','krējumu','sēnes','garšīgs',
						'sīpolu','paēd','čipsi','burkānu','pagaršo','kartupeļiem','neēdu','garšoja');
		$food3 = array('garšot','apēdu','maizītes','dārzeņiem','saldējumu','biešu','ēdusi','apēda',
						'neēst','pelmeņi','ēdīšu','šokolādi','Apelsīnu','Saldējums','salātus','apēdi',
						'rīšu','salātiem','ēdīsi','zemeņu','saldumus','apēdīs','noēd','piparkūku');
		$food4 = array('griķu','apetīte','mandarīnu','bulciņas','griķi','saldējuma','maizīti','izēd',
						'pagaršot','pelmeņus','piparkūkas','čipšus','rīsus','garšoju','neēda','pusdieno',
						'nogaršo','paēdu','uzēd','ēdat','rīsiem','neēdi','neēdīs','griķus');
		$food5 = array('mandarīni','maltīte','kārums','ieēst','garšos','ēdīsim','pagaršoju','uzkodu',
						'apēstu','noēst','uzēst','nogaršot','izēst','paēdi','neēdam','kūciņu','krēmzupa',
						'brokasto','vīnogas','mandarīnus','iekoda','apēdam','paēda','maķītī');
		$food6 = array('paēdīs','noēdi','noēdīs','hesītī','apēdot','iekož','končās','atēd','ieēd',
						'uzkodām','apēdīšu','notiesāt','izēda','garšotu','neēstu','neēdīšu','noēda',
						'pārēsties','garšojot','saēdies','uzēdu','saēdos','pusdienot','griķiem','paēdam');
		$food7 = array('izēdu','saēdas','vakariņo','garšoji','paēstu','pierīties','ēdīsiet','apēdīsi','noēstu',
						'ņamma','tējiņu','neēdot','pārēdos','pārēdies','nogaršoju','paēdīsi','uzēdi',
						'pagaršoja','uzēdīs','brokastot','uzkož','launagā','pusdienoju');
		$food8 = array('ieēdu','notiesāju','neēdīsi','noēdu','saēsties','iekostu','jāgaršo','atēst','izēdi',
						'brokastoju','pagaršoji','pagaršos','pusdienos','apēdīsim','pārēdas','pieēdos',
						'pusdienoja','apēdat','ieēda','izēdīs','brokastoja','brokastojot');
		$food9 = array('degustēt','paēdīšu','iekodīs','garšošu','nogaršotu','pagaršojot','izēstu',
						'brokastojam','pusdienojot','iekožu','garšosi','nogaršoja','nogaršos','pagaršošu',
						'paēdīsim','uzēdīšu','uzēdam','brokastos','griķos','pagaršotu','ēdīšot');
		$food10 = array('noēdīšu','ieēdam','noēdot','uzēdot','pieēsties','neēdīsim','pusdienojam',
						'degustēju','nogaršojam','ieēdi','neēdat','iekožot','noēdam','paēdat','saēdīšos',
						'saēdamies','saēdīsies','pieēdas','vakariņot','vakariņoja','vakariņojam');
		$food11 = array('pusdienās','brokastīs','vakariņās','garšīgi','kafiju','ēdienu','dzēriens','garšīgas',
						'mērcē','paēstas','zemenes','paēdām','cūkgaļas','kafijas','ēdis','apetīti','garšu',
						'kotletes','negaršo','garšīgu','biezpiena','končas','sēņu','ēdām');
		$food12 = array('konfektes','čipsus','jāpaēd','karbonāde','tomātiem','salātu','sautējums',
						'biezpienu','pīrāgs','garša','krējuma','brokastu','garšas','ēdiena','pusdienām',
						'ķirbju','karameļu','zirņu','skābeņu','vaniļas','zemenēm','ķiršu','gurķi');
		$food13 = array('dārzeņi','aveņu','ievārījumu','putukrējumu','banānu','ēdieni','pārtiku','gurķu',
						'ķiploku','ēšanas','ābolus','augļiem','arbūzu','laša','kefīrs','tomāti','ēdienus',
						'cūkgaļa','banānus','banāni','vakariņām','dārzeņus','brokastīm');
		$food14 = array('augļus','dzeršu','cūkgaļu','pankūku','majonēzi','olām','upeņu','karbonādes','kabaču',
						'apēdām','jāiedzer','sīpoliem','kūciņas','āboliem','pankūkām','paēdis','mērcīti',
						'āboli','biezzupa','biezpiens','spinātu','karbonādi','pupiņas');
		$food15 = array('grauzdiņiem','melleņu','ēdieniem','pupiņām','gardās','ābols','burkānus','ķīseli',
						'burkāniem','gulašs','kāpostiem','tomātus','jāizdzer','kumelīšu','plācenīši','šķiņķi',
						'gurķiem','banāniem','gurķus','dzērveņu','tostermaizes','zupiņa');
		$food16 = array('šašliku','tītara','ķiršus','cīsiņus','bulciņu','burkāni','aliņu','gaileņu','šampinjonu',
						'krējums','pankūciņas','aliņš','cāļa','tīteņi','ēšana','ribiņas','mērces','zupiņu',
						'borščs','brokastiņas','kāposti','sieriņu','šņabi','siļķi');
		$food17 = array('ogām','garšīgās','garšīgo','ananāsu','pieēdāmies','ievārījums','speķi','sīrupu',
						'kukurūzu','ēdienreizes','maizīte','pīrādziņi','pīrāgu','nūdeles','saldējumus','jāpadzer',
						'pīrādziņus','vistiņu','sīpolus','banāns','kefīru','sīpoli');
		$food18 = array('zirņi','salātiņiem','kāpostus','sautējumu','tunča','zirņus','šampinjoniem','šprotes',
						'pārēdusies','desiņas','zirnīšu','garšīgus','spinātiem','tomāts','cepumiņus','garnelēm',
						'pelmeņiem','šņabis','izdzeršu','ķiplokus','čipsu');
		$food19 = array('kukurūzas','pustdienas','mandeļu','salātiņi','rozīnēm','šokolādē','mandarīniem','dzērvenes',
						'salātiņus','cīsiņi','graužu','apelsīnus','apēstas','rupjmaizes','pīrāgus','ananāsiem',
						'apēdis','siļķe','ķirbi','majonēze','vakariņu');
		$food20 = array('gardā','rozīnes','ēdams','konfekšu','sviestmaizes','vistiņas','rupjmaizi','tējiņa','čipsiem',
						'maizītēm','ēdienreize','biezputru','kefīra','apēsts','zirnīšiem','garšīgāks','padzeršu',
						'vafeļu','sieriņš','tefteļi','mērcīte','pīrāgi');
		$food21 = array('pelmeņu','ķirši','uzēdām','desmaizes','gurķīšus','negaršoja','virtuļus','krēmzupu',
						'kotletēm','kabači','olīvas','šnicele','karstvīns','zupā','salātos','kūkām','brūkleņu',
						'šķiņķīši','sviestmaizi','cepumiņi','sieriņus');
		$food22 = array('šampanietis','diļļu','ķiploki','konfektēm','pankūka','burkāns','garneļu','pārslām','plūmes',
						'greipfrūtu','ēdienam','ķīselis','lašmaizītes','rupjmaize','siermaizītes','avenēm',
						'piparkūkām','grauzdiņus','siermaizes','pabarot');
		$food23 = array('ēšanu','pieēdies','čipši','soļanku','ēdienkartē','koņčas','nūdelēm','apēdusi',
						'kūciņa','majonēzes','mellenēm','vistiņa','ķiršiem','augļi','riekstiņus',
						'apelsīni','kartupelīši','dzērienu');
		
        $this->rule2->raw(array_reduce(Arr::wrap($food2), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule3->raw(array_reduce(Arr::wrap($food3), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule4->raw(array_reduce(Arr::wrap($food4), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule5->raw(array_reduce(Arr::wrap($food5), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule6->raw(array_reduce(Arr::wrap($food6), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule7->raw(array_reduce(Arr::wrap($food7), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule8->raw(array_reduce(Arr::wrap($food8), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule9->raw(array_reduce(Arr::wrap($food9), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule10->raw(array_reduce(Arr::wrap($food10), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule11->raw(array_reduce(Arr::wrap($food11), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule12->raw(array_reduce(Arr::wrap($food12), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule13->raw(array_reduce(Arr::wrap($food13), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule14->raw(array_reduce(Arr::wrap($food14), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule15->raw(array_reduce(Arr::wrap($food15), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule16->raw(array_reduce(Arr::wrap($food16), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule17->raw(array_reduce(Arr::wrap($food17), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule18->raw(array_reduce(Arr::wrap($food18), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule19->raw(array_reduce(Arr::wrap($food19), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule20->raw(array_reduce(Arr::wrap($food20), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule21->raw(array_reduce(Arr::wrap($food21), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule22->raw(array_reduce(Arr::wrap($food22), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
        $this->rule23->raw(array_reduce(Arr::wrap($food23), static function ($_, $listener) {
            if (empty($_)) {return $listener;}
            return $_ . ' OR ' . $listener;}));
		
        $this->onTweet = $whenHears;

        return $this;
    }

    public function whenFrom(array $boundingBoxes, callable $whenFrom): self
    {
        $this->rule->boundingBox($boundingBoxes);
        $this->onTweet = $whenFrom;

        return $this;
    }

    public function whenTweets(string | array $twitterUserIds, callable $whenTweets): self
    {
        $this->rule->from($twitterUserIds);
        $this->onTweet = $whenTweets;

        return $this;
    }

    public function setLocale(string $lang): self
    {
        $this->rule->locale($lang);

        return $this;
    }

    public function startListening(Sets $sets = null): void
    {
        // Delete old rules
        Rule::deleteBulk(...Rule::all());
        $this->rule->save();
        $this->rule2->save();
        $this->rule3->save();
        $this->rule4->save();
        $this->rule5->save();
        $this->rule6->save();
        $this->rule7->save();
        $this->rule8->save();
        $this->rule9->save();
        $this->rule10->save();
        $this->rule11->save();
        $this->rule12->save();
        $this->rule13->save();
        $this->rule14->save();
        $this->rule15->save();
        $this->rule16->save();
        $this->rule17->save();
        $this->rule18->save();
        $this->rule19->save();
        $this->rule20->save();
        $this->rule21->save();
        $this->rule22->save();
        $this->rule23->save();

        foreach ($this->stream->filteredTweets($sets) as $tweet) {
            if (is_null($tweet)) {
                continue;
            }

            call_user_func($this->onTweet, $tweet);
        }
    }
}
