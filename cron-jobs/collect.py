import asyncio
from twscrape import API, gather
from twscrape.logger import set_log_level
import mysql.connector as mysql
import sys,json
from datetime import datetime, timedelta
import time
import pytz

print('Connecting to the database...')

db = mysql.connect(user='', password='',host='',database='', port='')
cursor = db.cursor(buffered=True)

print('Connected to the database!\n')

valid_food = ['garšot','garšoju','garšošu','garšo','garšoji','garšosi','garšoja','garšos','garšojot','garšotu','jāgaršo','nogaršot',
            'nogaršoju','nogaršošu','nogaršo','nogaršoji','nogaršosi','nogaršoja','nogaršos','nogaršojam','nogaršojām','nogaršosim',
            'nogaršojat','nogaršojāt','nogaršojot','nogaršotu','pagaršot','pagaršoju','pagaršošu','pagaršo','pagaršoji','pagaršosi',
            'pagaršoja','pagaršos','pagaršojam','pagaršojām','pagaršosim','pagaršojat','pagaršojāt','pagaršojot','pagaršotu','ēdu',
            'ēdīšu','ēd','ēdi','ēdīsi','ēda','ēdīs','ēdam','ēdām','ēdīsim','ēdat','ēdāt','ēdīsiet','ēd','ēdot','ēdīšot','ēstu','jāēd',
            'apēst','apēdu','apēdīšu','apēd','apēdi','apēdīsi','apēda','apēdīs','apēdam','apēdām','apēdīsim','apēdat','apēdāt','apēdīsiet',
            'apēd','apēdot','apēdīšot','apēstu','atēst','atēdu','atēd','atēd','ieēst','ieēdu','ieēdīšu','ieēd','ieēdi','ieēdīsi','ieēda',
            'ieēdīs','ieēdam','ieēdām','ieēdīsim','ieēd','ieēdot','ieēstu','izēst','izēdu','izēdīšu','izēd','izēdi','izēdīsi','izēda',
            'izēdīs','izēdam','izēdām','izēdīsim','izēdat','izēdāt','izēdīsiet','izēd','izēstu','neēst','neēdu','neēdīšu','neēdi',
            'neēdīsi','neēda','neēdīs','neēdam','neēdām','neēdīsim','neēdat','neēdāt','neēd','neēdot','neēdīšot','neēstu','noēst','noēdu',
            'noēdīšu','noēd','noēdi','noēdīsi','noēda','noēdīs','noēdam','noēdām','noēdīsim','noēd','noēdot','noēstu','paēst','paēdu',
            'paēdīšu','paēd','paēdi','paēdīsi','paēda','paēdīs','paēdam','paēdām','paēdīsim','paēdat','paēdāt','paēd','paēdot','paēstu',
            'uzēst','uzēdu','uzēdīšu','uzēd','uzēdi','uzēdīsi','uzēda','uzēdīs','uzēdam','uzēdām','uzēdīsim','uzēdat','uzēdāt','uzēdīsiet',
            'uzēd','uzēdot','uzēstu','saēsties','saēdos','saēdīšos','saēdies','saēdīsies','saēdas','saēdās','saēdīsies','saēdamies',
            'saēdāmies','saēdīsimies','saēdaties','saēdāties','saēdoties','saēstos','jāsaēdas','pārēsties','pārēdos','pārēdīšos','pārēdies',
            'pārēdīsies','pārēdas','pārēdās','pārēdīsies','pārēdamies','pārēdāmies','pārēdīsimies','pārēdoties','pārēstos','pieēsties',
            'pieēdos','pieēdīšos','pieēdies','pieēdīsies','pieēdas','pieēdās','pieēdīsies','pieēdamies','pieēdāmies','pieēdīsimies',
            'pieēdoties','pieēstos','brokastot','brokastoju','brokastošu','brokasto','brokastoji','brokastosi','brokastoja','brokastos',
            'brokastojam','brokastojām','brokastosim','brokastojat','brokastojāt','brokastojot','jābrokasto','pusdienot','pusdienoju',
            'pusdienošu','pusdieno','pusdienoji','pusdienosi','pusdienoja','pusdienos','pusdienojam','pusdienojām','pusdienosim',
            'pusdienojat','pusdienojāt','pusdienojot','pusdienotu','jāpusdieno','vakariņot','vakariņoju','vakariņošu','vakariņo',
            'vakariņoji','vakariņosi','vakariņoja','vakariņos','vakariņojam','vakariņojām','vakariņosim','vakariņojot','iekožu',
            'iekodīšu','iekodīsi','iekož','iekoda','iekodīs','iekožam','iekodām','iekodīsim','iekožot','iekostu','jāiekož','uzkožu',
            'uzkodu','uzkodīšu','uzkodīsi','uzkož','uzkodīs','uzkožam','uzkodām','uzkodīsim','uzkožat','maltīte','garšīgs','garšīga',
            'kārums','ņam','ņamma','apetīte','ēdiens','brokastis','pusdienas','vakariņas','brokastīs','pusdienās','vakariņās','launagā',
            'ēst','ēdis','ēdusi','notiesāju','notiesāšu','notiesāt','mandarīnus','saldējumu','tēju','pankūkas','šokolādi','šokolādes',
            'kūku','čipšus','kafija','tēja','gaļu','končās','pelmeņus','piparkūkas','maizītes','mērci','ābolu','gaļas','kartupeļu',
            'šokolāde','salātus','saldumus','hesītī','mandarīnu','kūkas','kartupeļus','mērce','tomātu','mandarīni','pelmeņi','Apelsīnu',
            'Dārzeņu','salāti','saldējuma','Saldējums','kartupeļiem','tējas','maķītī','krēmzupa','Kārums','bulciņas','salātiem','zemeņu',
            'piparkūku','maizīti','tējiņu','kūciņu','kāpostu','čipsi','sīpolu','vīnogas','krējumu','biešu','burkānu','rīsiem','dārzeņiem',
            'sēnes','degustēju','degustēt','degustēšu','griķi','griķus','griķiem','griķu','griķos','rīsi','rīsus','rīšu','pierīties',
            'pusdienās','brokastīs','vakariņās','garšīgi','kafiju','ēdienu','dzēriens','garšīgas','mērcē','paēstas','zemenes','paēdām',
            'cūkgaļas','kafijas','ēdis','apetīti','garšu','kotletes','negaršo','garšīgu','biezpiena','končas','sēņu','ēdām','banānu',
            'konfektes','čipsus','jāpaēd','karbonāde','tomātiem','salātu','sautējums','suši','biezpienu','pīrāgs','garša','krējuma',
            'brokastu','garšas','ēdiena','pusdienām','ķirbju','karameļu','zirņu','skābeņu','vaniļas','zemenēm','ķiršu','gurķi','dārzeņi',
            'aveņu','ievārījumu','putukrējumu','ēdieni','pārtiku','gurķu','ķiploku','ēšanas','ābolus','augļiem','arbūzu','laša','kefīrs',
            'tomāti','ēdienus','cūkgaļa','banānus','banāni','vakariņām','dārzeņus','brokastīm','augļus','dzeršu','cūkgaļu','pankūku',
            'majonēzi','olām','upeņu','karbonādes','kabaču','apēdām','jāiedzer','sīpoliem','kūciņas','āboliem','pankūkām','paēdis',
            'mērcīti','āboli','biezzupa','biezpiens','spinātu','karbonādi','pupiņas','grauzdiņiem','melleņu','ēdieniem','pupiņām',
            'gardās','ābols','burkānus','ķīseli','burkāniem','gulašs','kāpostiem','tomātus','jāizdzer','kumelīšu','plācenīši','šķiņķi',
            'gurķiem','banāniem','gurķus','dzērveņu','tostermaizes','zupiņa','šašliku','tītara','ķiršus','cīsiņus','bulciņu','burkāni',
            'aliņu','gaileņu','šampinjonu','krējums','pankūciņas','aliņš','cāļa','tīteņi','ēšana','ribiņas','mērces','zupiņu','borščs',
            'brokastiņas','kāposti','sieriņu','šņabi','siļķi','ogām','garšīgās','garšīgo','ananāsu','pieēdāmies','ievārījums','speķi',
            'sīrupu','kukurūzu','ēdienreizes','maizīte','pīrādziņi','pīrāgu','nūdeles','saldējumus','jāpadzer','pīrādziņus','vistiņu',
            'sīpolus','banāns','kefīru','sīpoli','zirņi','salātiņiem','kāpostus','sautējumu','tunča','zirņus','šampinjoniem','šprotes',
            'pārēdusies','desiņas','zirnīšu','garšīgus','spinātiem','tomāts','cepumiņus','garnelēm','pelmeņiem','šņabis','izdzeršu',
            'ķiplokus','čipsu','kukurūzas','pustdienas','mandeļu','salātiņi','rozīnēm','šokolādē','mandarīniem','dzērvenes','salātiņus',
            'cīsiņi','graužu','apelsīnus','apēstas','rupjmaizes','pīrāgus','ananāsiem','apēdis','siļķe','ķirbi','majonēze','vakariņu',
            'gardā','rozīnes','ēdams','konfekšu','sviestmaizes','vistiņas','rupjmaizi','tējiņa','čipsiem','maizītēm','ēdienreize',
            'biezputru','kefīra','apēsts','zirnīšiem','garšīgāks','padzeršu','vafeļu','sieriņš','tefteļi','mērcīte','pīrāgi','pelmeņu',
            'ķirši','uzēdām','desmaizes','gurķīšus','negaršoja','virtuļus','krēmzupu','kotletēm','kabači','olīvas','šnicele','karstvīns',
            'zupā','salātos','kūkām','brūkleņu','šķiņķīši','sviestmaizi','cepumiņi','sieriņus','šampanietis','diļļu','ķiploki','dzērienu',
            'konfektēm','pankūka','burkāns','garneļu','pārslām','plūmes','greipfrūtu','ēdienam','ķīselis','lašmaizītes','rupjmaize',
            'siermaizītes','avenēm','piparkūkām','grauzdiņus','siermaizes','pabarot','ēšanu','pieēdies','čipši','soļanku','ēdienkartē',
            'koņčas','nūdelēm','apēdusi','kūciņa','majonēzes','mellenēm','vistiņa','ķiršiem','augļi','riekstiņus','apelsīni','kartupelīši',
            'late','latte','lates','lattes','kapučino','kapučīno']

spammers = ['berelilah_jpg', 'Twitediens', 'dievietelv', 'CrabstickFusion', 'oreotsuka', 'pingwsie', 'taunlts']

def is_dst(zonename):
    tz = pytz.timezone(zonename)
    now = pytz.utc.localize(datetime.utcnow())
    return now.astimezone(tz).dst() != timedelta(0)

def clean_text(text):

    text = text.replace("\n", " ")
    text = text.replace("\t", " ")
    text = text.replace("<br>", " ")
    text = text.replace("</br>", " ")
    text = text.replace("-", " ")
    text = text.replace(",", " ")
    text = text.replace(";", " ")
    text = text.replace(":", " ")
    text = text.replace(".", " ")
    text = text.replace("/", " ")
    text = text.replace("]", " ")
    text = text.replace("[", " ")
    text = text.replace(")", " ")
    text = text.replace("(", " ")
    text = text.replace("!", " ")
    text = text.replace("?", " ")
    text = text.replace("'", " ")
    text = text.replace('"', ' ')
    text = text.replace('#', " ")
    text = text.replace("  ", " ")

    return text

def trashy_count(text):
    badChars = ["𝓪","𝞪","ă","å","𝛼","𝐚","à","á","ä","Æ","æ","ǣ","α","𝗮","𝜶","ａ","𝒂","â","𝘢","𝗔","ȃ","Ã","ã",
                "Ƅ",
                "ď","𝗱","𝖣","𝓭","𝒅","𝐝","𝗗",
                "ę","Ę","ȩ","𝐞","𝗲","𝑒","ｅ","ȅ","ҽ","ë","𝙚","𝘦","ě","ê","𝔢","é","ĕ","è","𝗘","𝒆",
                "𝖿","𝒇","𝘧","𝗳","ẝ","𝑓",
                "ġ","ǧ",
                "𝐡","𝙝","𝔥","ħ",
                "Ĩ","Ȉ","İ","Ĭ","Į","𝚤","ꭵ","î","Î","𝖎","ǐ","į","í","Ï","ı",
                "𝙠","𝒌","𝐤","𝗸",
                "ȯ","ò","ō","ȫ","𝝾","𝗼","𝞸","𝐨","õ","ȭ","ó","ø","ö","Ø","𝙤","ǒ","၀","𝘰","𝒐","𝗈","Ô","ð",
                "ŀ","𐌠",
                "ᗰ","𝗺",
                "ŉ","𝖓","𝐧","𝗻","ñ","ǹ","𝘯","𝗇","ń","𝑛",
                "𝛒","𝗣","𝗽",
                "𝐫","𝔯","𝗿",
                "𝘁","ŧ","ț","𝖙","𝒕","𝗧",
                "𝘀","ŝ","𝑠","𝒔","ƽ","ś","ș","𝓈",
                "ȗ","ǖ","ǜ","ȕ","ű","𝙪","𝞄","û","ú","ü","ų","ŭ","ǘ","𝗨","𝛖","Ù",
                "𝒘","𝓦","ѡ","𝘄","Ŵ","𝙬","𝗪",
                "𝔁","𝘹",
                "ÿ","ч","𝛾","ȳ","ŷ","𝒚",
                "ß",
                "𓈊","𓋲",
                "ء","،","خ","ا","ف","ث","ً","،","ش","ر","ض","و","م","ق","ع","ز","ة","،","إ","س","ئ","ل","ك","ن","ي","أ","ح","ب","ت","ه"]
    trashy = 0
    for char in badChars:
        if char in text:
            trashy+=1

    return trashy

def  remove_mentions(text):
    # Count of all mentions
    atcount = text.count("@")
    # Position of last mention
    if atcount > 0:
        position = text.rindex("@")
        # Trim if more than 10 mentions...
        if atcount > 10 or len(text) > 450:
            text = text[position:]
    return text

def add_tweet(id, text, screen_name, created_at, geo, quoted = None):
    if quoted == None:
        sql = "INSERT IGNORE INTO tweets (id ,text ,screen_name, created_at, geo) VALUES (%s, %s, %s, %s, %s)"
        val = (id, text, screen_name, created_at, geo)
    else:
        sql = "INSERT IGNORE INTO tweets (id ,text ,screen_name, created_at, geo, quoted_id) VALUES (%s, %s, %s, %s, %s, %s)"
        val = (id, text, screen_name, created_at, geo, quoted)
    cursor.execute(sql, val)

def add_word(vards, nominativs, tvits, grupa, eng, datums):
    sql = "INSERT IGNORE INTO words (vards, nominativs, tvits, grupa, eng, datums) VALUES (%s, %s, %s, %s, %s, %s)"
    val = (vards, nominativs, tvits, grupa, eng, datums)
    cursor.execute(sql, val)

def add_media(tweet_id, media_url, date):
    sql = "INSERT IGNORE INTO media (tweet_id, media_url, date) VALUES (%s, %s, %s)"
    val = (tweet_id, media_url, date)
    cursor.execute(sql, val)
    # print('Media added?\n')

def add_mention(screen_name, tweet_id, mention, date):
    sql = "INSERT IGNORE INTO mentions (screen_name, tweet_id, mention, date) VALUES (%s, %s, %s, %s)"
    val = (screen_name, tweet_id, mention, date)
    cursor.execute(sql, val)

def save_tweet(tweet, recent_ids, food_names):

    # Format the date
    tweetDate = tweet['date']
    if is_dst("Europe/Riga"):
        hourdiff = 3
    else:
        hourdiff = 2

    if str(tweetDate)[-6:] == '+00:00':
        DBformat = "%Y-%m-%d %H:%M:%S"
        real_time = tweetDate + timedelta(hours=hourdiff)
        LVdate = format(real_time, DBformat)

    if tweet['user']['username'] not in spammers:
        # Maybe insert in DB from here
        quoted_id = None
        if tweet['quotedTweet'] is not None:
            # Insert if does not exist yet
            # select = "SELECT id FROM tweets where id = %s"
            # value = (quoted_id,)
            # cursor.execute(select, value)

            # if cursor.rowcount == 0:
            if quoted_id not in recent_ids:
                saved_quote = save_tweet(tweet['quotedTweet'], recent_ids, food_names)
                if saved_quote:
                    quoted_id = tweet['quotedTweet']['id']

        # attīra
        tweet_text = tweet['rawContent']
        ntext = clean_text(tweet_text);
        tc = trashy_count(tweet_text);
        edieni = 0;

        if len(ntext)>0:
            vardi = ntext.split()
            edienVardi = []
            RLYsave = False
            for vards in vardi:

                vards = vards.replace("  ", "")
                vards = vards.replace(" ", "")
                vards = vards.replace("-", "")
                vards = vards.replace("'", "")
                vards = vards.replace('"', '')

                if len(vards) > 2 and vards[0:4]!='http' and not any(char.isdigit() for char in vards) and not any(substring in vards for substring in ['@','#','\n','\r']):
                    edienVardi.append(vards)
                    if vards in valid_food:
                        RLYsave = True

            # Skip saving at this point if no food words actually found in the text
            if not RLYsave:
                return False

            myset = set(edienVardi)
            edienVardi = list(myset)

            for edienvards in edienVardi:

                # select = "SELECT nominativs, grupa, eng FROM words WHERE tvits != %s AND LOWER(CAST(vards AS CHAR CHARACTER SET utf8)) = LOWER(CAST(%s AS CHAR CHARACTER SET utf8)) LIMIT 1"
                # value = (tweet['id'], edienvards)
                # cursor.execute(select, value)
                # if cursor.rowcount > 0:
                #     results = cursor.fetchall()
                ev = edienvards.lower()

                if ev in food_names:

                    nom = food_names[ev]["nom"]
                    gru = food_names[ev]["gru"]
                    eng = food_names[ev]["eng"]

                    edieni+=1

                    add_word(edienvards, nom, tweet['id'], gru, eng, LVdate)

            retweet = tweet_text[0:4] == "RT @";

            if RLYsave and not retweet and (edieni > 0 or tweet_text[0]=="@" or tc < 3):

                insert_text = remove_mentions(tweet_text)

                if tweet['place'] is not None:
                    if tweet['place']['name'] is not None:
                        geo = tweet['place']['name']
                else:
                    geo = None

                add_tweet(tweet['id'], insert_text, tweet['user']['username'], LVdate, geo, quoted_id)

                for photo in tweet['media']['photos']:
                    add_media(tweet['id'], photo['url'], LVdate)
                for user in tweet['mentionedUsers']:
                    add_mention(tweet['user']['username'], tweet['id'], user['username'], LVdate)

                db.commit()
                return True


async def main():
    api = API()  # or API("path-to.db") - default is `accounts.db`

    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.add_account("USERNAME", "PASSWORD", "EMAIL", "_")
    await api.pool.login_all()

    set_log_level("DEBUG")

    # Tweet & User model can be converted to regular dict or json, e.g.:

    # 28 most common keywords with the highest hit-rate    
    keywords = ["ēdu", "ēd", "ēdam", "ēst", "paēst", "garšo", "pusdieno", "vakariņo", "brokasto", "pusdienas",
                 "vakariņas", "brokastis", "šokolāde", "gaļa", "ēdiens", "kartupeļu", "pankūka", "salāti", 
                 "ābolu", "kūku", "ņam", "saldējums", "tomātu", "mērci", "garšīgs", "dārzeņu", "ēdīšu", "saldējumu"]

    # 22 next most common keywords with a high hit-rate    
    more_keywords = ["kafija", "tēja", "paēd", "tēju", "apēd", "kūkas", "tējas", "paēdu", "apēst", "ēdīs", 
                    "garšīga", "neēd", "apēdu", "mandarīnu", "saldumus", "maizītes", "pelmeņus", "zemeņu",
                    "ēdot", "dārzeņiem", "mandarīni", "salātus"]

    # 21 further most common keywords with a good hit-rate    
    even_more_kw = ["ēdusi", "kāpostu", "kartupeļiem", "ēdis", "garšot", "ieēd", "apēda", "piparkūkas", 
                    "mandarīnus", "jāēd", "ēstu", "pelmeņi", "uzēd","sēnes", "ēdīsi", "pusdienās", 
                    "brokastīs","vakariņās","ēdām", "kartupeļus", "ēdīsim"]

    kw_groups = [keywords, more_keywords, even_more_kw]

    recent_max = 5000

    if(len(sys.argv) > 1):
        k_from  = sys.argv[1] # "2024-01-01"
        k_to    = sys.argv[2] # "2024-01-27" 
        recent_max = 40000
    else:
        tomorrow = datetime.now() + timedelta(1)
        yesterday = datetime.now() - timedelta(1)
        today = datetime.now()

        k_from = datetime.strftime(yesterday, '%Y-%m-%d')
        k_to = datetime.strftime(tomorrow, '%Y-%m-%d')
    # Maybe needs day+1 to get tweets from the day

    print("Searching for tweets between "+ k_from + " and " + k_to)

    # Before inserting any tweets, select the last... 5000 inserted tweet IDs, keep the list in memory and only insert if not in list
    recent_ids = []
    tweet_id_select = "SELECT id FROM `tweets` ORDER BY created_at DESC LIMIT 0, " + str(recent_max)
    cursor.execute(tweet_id_select)
    for result in cursor:
        recent_ids.append(result[0])

    print("Got " + str(len(recent_ids)) + " recent tweet IDs for double-checking.")

    # Now do the same for the ~2000 food names
    food_names = {}
    food_name_select = "SELECT DISTINCT LOWER(CAST(vards AS CHAR CHARACTER SET utf8)) as vards, nominativs, grupa, eng FROM `words` ORDER BY vards; "
    cursor.execute(food_name_select)
    for result in cursor:
        food_names[result[0]] = {"nom":result[1], "gru":result[2], "eng":result[3]}

    print("Got " + str(len(food_names)) + " food names for double-checking.")

    added_count = 0

    for kw_group in kw_groups:
        keywordstring = ' OR '.join(kw_group)

        doc = await gather(api.search(keywordstring+" lang:lv -filter:nativeretweets since:"+k_from+" until:"+k_to, limit=3200, kv={"product": "Latest"}))

        print("Found " + str(len(doc)) + " tweets. Processing...")
        

        # with open('tweet-data-now.json', 'w', encoding='utf-8') as f:
        #     for entry in doc:
        #         # json.dump(entry.json(), f, ensure_ascii=False, indent=2)
        #         string = json.dumps(entry.json(), ensure_ascii=True, indent=2)
        #         f.write(string + "\n")

        for entry in doc:
            tweet = entry.dict()

            # Before inserting any tweets, select the last... 5000 inserted tweet IDs, keep the list in memory and only insert if not in list

            if tweet['id'] not in recent_ids:
                saved = save_tweet(tweet, recent_ids, food_names)
                if saved:
                    added_count += 1

        time.sleep(20)

    print("Saved " + str(added_count) + " new tweets.")


if __name__ == "__main__":
    asyncio.run(main())