#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# Telegram bots for Volunteer Management System
# Copyright BotSourcing 2018
# !/usr/bin/env python
# -*- coding: utf-8 -*-

import logging
import telegram
from telegram.error import NetworkError, Unauthorized
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove)
from time import sleep
import time
import datetime

import re
import MySQLdb

global update_id
update_id = None
new_message = 0
position = ''
jurnal = ''
a = 0
reglist = []
user_state = {}


def main():
    """Run the bot."""
    global new_message
    global logger
    global a
    global reglist
    global user_state
    # Telegram Bot Authorization Token
	
    bot = telegram.Bot('<TOKEN_API>')
    print 'Bot is starting ...'
    # get the first pending update_id, this is so we can skip over it in case
    # we get an "Unauthorized" exception.
    try:
        update_id = bot.get_updates()[0].update_id
    except IndexError:
        update_id = None
    new_message = 0
    a = 0
    logging.basicConfig(format='%(asctime)s - %(name)s - %(levelname)s - %(message)s')
    logger = logging.getLogger(__name__)
    while True:
        try:
            loop(bot)
        except NetworkError:
            sleep(1)
        except Unauthorized:
            # The user has removed or blocked the bot.
            update_id += 1


def loop(bot):
    global update_id
    global a
    global reglist
    global user_state
    global new_message
    global position
    global jurnal
    """Echo the message the user sent."""
    # Request updates after the last update_id
    try:

        for update in bot.get_updates(offset=update_id, timeout=3600):
            update_id = update.update_id + 1
            # new_message = auth(bot, update)
            # print update.message.chat.id
            user = update.message.from_user
            msg = update.message.text

            # cek pesan baru dari user
            if (update.update_id == update_id):
                print 'Sama'
                new_message = 0
            else:
                # print 'Pesan Baru'
                # print a
                new_message = 1

            if (msg == '/start'):
                print(msg)
                #position = ''
                update.message.reply_text("Halo, selamat bergabung di manajemen RPTRA.")
                update.message.reply_text("Saya Tiny, asisten Anda yang akan membantu aktivitas RPTRA.")
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM chatsessions WHERE KoordinatorTelegram = '%s'" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    update.message.reply_text("Anda telah terdaftar di sistem manajemen RPTRA")
                    position='free'
                    # sudah ada state
                    for row in rows:
                       a = row[2]
                       position = row[3]
                else:
                    position='reg'
                    update.message.reply_text("Sebelumnya mohon melakukan tahap registrasi terlebih dahulu untuk semua koordinator RPTRA")
                    
            if(new_message == 1):
                print('Position is %s' % position)
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM chatsessions WHERE KoordinatorTelegram = '%s'" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    for row in rows:
                        print 'Sudah ada state'
                        a = row[2]
                        position = row[3]
                else:
                    position='reg'

            if msg=='/jurnal':
                update.message.reply_text("Halo, ada hal menarik yang ingin kamu sampaikan.")
                position='/jurnal'
                a=0
                new_message=0
                updatestate(position, a, update.message.chat.id)

            if position=='/jurnal' and new_message==1 and a==0:
                print(msg)
                #ts = time.time()
                #timestamp = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
                timestamp = time.strftime('%Y-%m-%d %H:%M:%S')
                print(timestamp)
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("""INSERT INTO jurnal VALUES (0,%s,%s,%s)""",
                               (msg, update.message.chat.id, timestamp))
                db.commit()

                update.message.reply_text(
                    "Terima kasih %s %s telah mengisi jurnal" % (user.first_name, user.last_name))
                a=1
                new_message=0
                position='free'
                updatestate(position, a, update.message.chat.id)
                    
            if msg=='/survey':
                position='/survey'
                a=7
                new_message=1
                update.message.reply_text("Silakan klik link di bawah ini untuk memulai survey \n"
                    "http://bot.sumapala.com/rptra/botinterface/survey/%s" % update.message.chat.id)

                # msg="<a href='http://bot.sumapala.com/rptra/index.php/botinterface/survey/%s'>Klik disini</a>" % update.message.chat.id;
                # update.message.reply_text(text=msg, parse_mode='HTML')

            if msg=='/jurnalku':
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM jurnal WHERE JurnalKoordinatorTelegram = '%s' ORDER BY JurnalId DESC" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    # sudah ada state
                    for row in rows:
                       update.message.reply_text('[' + str(row[3]) + '] ' + row[1])

                    position='free'
         
            if (a == 0 and new_message == 1 and position=='reg'):
                update.message.reply_text("Nama Anda?")
                # print update.update_id
                a = 1
                new_message = 0
                savestate(position, a, update.message.chat.id)
            if (a == 1 and new_message == 1 and position=='reg'):
                reglist.append(msg)
                update.message.reply_text("RPTRA mana yang Anda koordinasikan?")
                # print reglist
                a = 3
                new_message = 0
                updatestate(position, a, update.message.chat.id)
            if (a == 3 and new_message == 1 and position=='reg'):
                reglist.append(msg)
                reply_keyboard = [['Jakarta Pusat'], ['Jakarta Utara'], ['Jakarta Barat'], ['Jakarta Timur'], ['Jakarta Selatan']]
                update.message.reply_text(
                    'Dimana keberadaan wilayah RPTRA Anda? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                # print reglist
                a = 4
                new_message = 0
                updatestate(position, a, update.message.chat.id)
            if (a == 4 and new_message == 1 and position=='reg'):
                reglist.append(msg)
                update.message.reply_text("Selanjutnya mohon untuk share location RPTRA Anda", reply_markup=ReplyKeyboardRemove())
                # print reglist
                a = 5
                new_message = 0
                updatestate(position, a, update.message.chat.id)
            if (a == 5 and new_message == 1 and position=='reg'):
                reglist.append(update.message.location.latitude)
                reglist.append(update.message.location.longitude)
                update.message.reply_text("Dokumentasi foto RPTRA Anda?")
                # print reglist
                a = 6
                new_message = 0
                updatestate(position, a, update.message.chat.id)
            if (a == 6 and new_message == 1 and position=='reg'):
                photo_file = bot.get_file(update.message.photo[-1].file_id)
                msg = str(update.message.chat.id) + 'photo.jpg'
                photo_file.download(str(update.message.chat.id) + 'photo.jpg')
                reglist.append(msg)
                print reglist[0], reglist[1], reglist[2], reglist[3], reglist[4]
                # insert database
                try:
                    db = MySQLdb.connect("localhost", "root", "", "rptra")
                    cursor = db.cursor()
                    cursor.execute("""INSERT INTO koordinator VALUES (0,%s,%s,%s,%s,%s,%s,%s)""",
                                   (reglist[0], reglist[1], reglist[2], reglist[3], reglist[4], reglist[5], update.message.chat.id))
                    db.commit()

                    update.message.reply_text(
                        "Terima kasih %s %s ,tahap registrasi Anda sudah selesai" % (user.first_name, user.last_name))
                    update.message.reply_text(
                        "Kedepannya Tiny akan update kepada %s untuk aktivitas sehari-hari di RPTRA" % (
                            user.first_name))
                    update.message.reply_text("Semangat %s %s !!" % (user.first_name, user.last_name))

                    # clear state
                    a = 0
                    new_message = 0
                    position = 'free'
                    updatestate(position, a, update.message.chat.id)
                except MySQLdb.Error, e:
                    try:
                        print "MySQL Error [%d]: %s" % (e.args[0], e.args[1])
                        update.message.reply_text(
                            "Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
                        return None
                    except IndexError:
                        print "MySQL Error: %s" % str(e)
                        update.message.reply_text(
                            "Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
                        return None
                except TypeError, e:
                    print(e)
                    update.message.reply_text(
                        "Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
                    return None
                except ValueError, e:
                    print(e)
                    update.message.reply_text(
                        "Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
                    return None
                finally:
                    cursor.close()
                    db.close()
            # start survey reglist[5]

            # end survey reglist[16]

            if position=='free':
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM chatsessions WHERE KoordinatorTelegram = '%s'" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows) > 0:
                    for row in rows:
                        a = row[2]
                        position = row[3]
                else:
                    position = 'reg'

                update.message.reply_text('ketik /survey untuk memulai survey \n\n'
                                            'ketik /jurnal untuk memberikan aspirasi, kritik, saran atau curhatanmu \n\n'
                                            'ketik /jurnalku untuk membaca kembali jurnal yang sudah kamu tulis')


    except Exception as e:
        print(e)

def savestate(state, questionId, chatId):
    db = MySQLdb.connect("localhost", "root", "", "rptra")
    cursor = db.cursor()
    cursor.execute("""INSERT INTO chatsessions VALUES (0,%s,%s,%s)""",
                   (chatId, questionId, state))
    db.commit()
    cursor.close()
    db.close()

def updatestate(state, questionId, chatId):
    db = MySQLdb.connect("localhost", "root", "", "rptra")
    cursor = db.cursor()
    cursor.execute("""UPDATE chatsessions SET QuestionId=%s, State=%s WHERE KoordinatorTelegram=%s""",
                   (questionId, state, chatId))
    db.commit()
    cursor.close()
    db.close()


if __name__ == '__main__':
    main()
