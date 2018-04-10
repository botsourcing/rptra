#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# Telegram bots for Volunteer Management System
# Copyright BotSourcing 2018
# TOKEN: 465109632:AAHlD6FWnCopcFQktjgk_qrUH1KghmgGhVg
# !/usr/bin/env python
# -*- coding: utf-8 -*-

import logging
import telegram
from telegram.error import NetworkError, Unauthorized
from telegram import (ReplyKeyboardMarkup, ReplyKeyboardRemove)
from time import sleep
from telegram.ext import (Updater, CommandHandler, MessageHandler, Filters, RegexHandler,
                          ConversationHandler)
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
    bot = telegram.Bot('551359175:AAGG6LYJON8m702RygBUXnH5kP_ddZ7qC14')

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
                cursor.execute("SELECT * FROM koordinator WHERE KoordinatorTelegram = '%s'" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    update.message.reply_text("Anda telah terdaftar di sistem manajemen RPTRA")
                    position='free'
                    # sudah ada state
                    for row in rows:
                       questionId = row[1]
                       state = row[2]
                else:
                    position='reg'
                    update.message.reply_text("Sebelumnya mohon melakukan tahap registrasi terlebih dahulu untuk semua koordinator RPTRA")
                    
            if(new_message == 1):
                print('Position is %s' % position)
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM koordinator WHERE KoordinatorTelegram = '%s'" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    if position=='/survey':
                       position='/survey'
                    elif position=='reg':
                       position='reg'
                    elif position=='/jurnal':
                       position='/jurnal'
                    elif position=='/jurnalku':
                       position='/jurnalku'
                    else:
                         position='free'
                    # sudah ada state
                    for row in rows:
                       questionId = row[1]
                       state = row[2]
                else:
                    position='reg'

            if msg=='/jurnal':
                update.message.reply_text("Halo, ada hal menarik yang ingin kamu sampaikan.")
                position='/jurnal'
                jurnal=0
                new_message=0

            if position=='/jurnal' and new_message==1 and jurnal==0:
                print(msg)
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("""INSERT INTO jurnal VALUES (0,%s,%s,0)""",
                               (msg, update.message.chat.id))
                db.commit()

                update.message.reply_text(
                    "Terima kasih %s %s telah mengisi jurnal" % (user.first_name, user.last_name))
                jurnal=1
                new_message=0
                position='free'
                    
            if msg=='/survey':
                position='/survey'
                a=7
                new_message=1

            if msg=='/jurnalku':
                db = MySQLdb.connect("localhost", "root", "", "rptra")
                cursor = db.cursor()
                cursor.execute("SELECT * FROM jurnal WHERE JurnalKoordinatorTelegram = '%s' ORDER BY JurnalId DESC" % update.message.chat.id)
                rows = cursor.fetchall()
                cursor.close()
                if len(rows)>0:
                    # sudah ada state
                    for row in rows:
                       update.message.reply_text(row[1])

                    position='free'
         
            if (a == 0 and new_message == 1 and position=='reg'):
                update.message.reply_text("Nama Anda?")
                # print update.update_id
                a = 1
                new_message = 0
            if (a == 1 and new_message == 1 and position=='reg'):
                reglist.append(msg)
                update.message.reply_text("RPTRA mana yang Anda koordinasikan?")
                # print reglist
                a = 4
                new_message = 0
            if (a == 4 and new_message == 1 and position=='reg'):
                reglist.append(msg)
                update.message.reply_text("Selanjutnya mohon untuk share location RPTRA Anda")
                # print reglist
                a = 5
                new_message = 0
            if (a == 5 and new_message == 1 and position=='reg'):
                reglist.append(update.message.location.latitude)
                reglist.append(update.message.location.longitude)
                update.message.reply_text("Dokumentasi foto RPTRA Anda?")
                # print reglist
                a = 6
                new_message = 0
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
                    cursor.execute("""INSERT INTO koordinator VALUES (0,%s,%s,%s,%s,%s,%s)""",
                                   (reglist[0], reglist[1], reglist[2], reglist[3], reglist[4], update.message.chat.id))
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
            if (a == 7 and new_message == 1 and position=='/survey'):
                # pertanyaan mainan
                # reply_keyboard = [['Papan Tulis'], ['Speaker'], ['Jungkat Jungkit']]
                update.message.reply_text(
                    'Halo %s %s , mainan atau fasilitas apa saja yang dibutuhkan oleh RPTRA Anda '
                    'untuk meningkatkan kepuasan pengguna '
                    'dan keberlangsungan kegiatan?' % (user.first_name, user.last_name))
                a = 8
                new_message = 0
                position == '/survey'
            if (a == 8 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '1', msg)
                insert('rptra', query)
                # pertanyaan PKK 1
                reply_keyboard = [['Sangat Buruk'], ['Buruk'], ['Cukup'], ['Baik'], ['Sangat Baik']]
                update.message.reply_text(
                    'Pertama - tama, bagaimana kinerja keseluruhan PKK Mart? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 9
                new_message = 0
            if (a == 9 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '2', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Sangat Buruk'], ['Buruk'], ['Cukup'], ['Baik'], ['Sangat Baik']]
                update.message.reply_text(
                    'Bagaimana untuk ketersediaan produk/barang di dalam PKK Mart? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 10
                new_message = 0
            if (a == 10 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '3', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Sangat Buruk'], ['Buruk'], ['Cukup'], ['Baik'], ['Sangat Baik']]
                update.message.reply_text(
                    'Bagaimana ketertarikan pengunjung RPTRA terhadap PKK Mart? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 11
                new_message = 0
            if (a == 11 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '4', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Sangat Buruk'], ['Buruk'], ['Cukup'], ['Baik'], ['Sangat Baik']]
                update.message.reply_text(
                    'Untuk kualitas pengelolaan operasional PKK Mart, bagaimana menurut Anda sebagai koordinator RPTRA? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 12
                new_message = 0
            if (a == 12 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '5', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Anak umur 5-7 tahun'], ['Anak umur 7-12 tahun'], ['Remaja umur 12-17 tahun'],
                                  ['Dewasa']]
                update.message.reply_text(
                    'Untuk kawasan RPTRA Anda, siapa saja sih yang paling banyak mengunjungi RPTRA? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 13
                new_message = 0
            if (a == 13 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '6', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Laki-laki'], ['Perempuan']]
                update.message.reply_text(
                    'Lebih banyak laki-laki atau perempuan? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 14
                new_message = 0
            if (a == 14 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '7', msg)
                insert('rptra', query)
                # pertanyaan PKK
                reply_keyboard = [['Menengah ke bawah'], ['Menengah ke atas']]
                update.message.reply_text(
                    'Dari kalangan ekonomi sosial yang seperti apa yang sering mengunjungi RPTRA? ',
                    reply_markup=ReplyKeyboardMarkup(reply_keyboard, one_time_keyboard=True))
                a = 15
                new_message = 0
            if (a == 15 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '8', msg)
                insert('rptra', query)
                # pertanyaan PKK
                # reply_keyboard = [['Menengah ke bawah'], ['Menengah ke atas']]
                update.message.reply_text(
                    'Apa saja 3 kegiatan yang paling sering dilakukan di RPTRA? ', reply_markup=ReplyKeyboardRemove())
                a = 16
                new_message = 0
            if (a == 16 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '9', msg)
                insert('rptra', query)
                # pertanyaan PKK
                # reply_keyboard = [['Menengah ke bawah'], ['Menengah ke atas']]
                update.message.reply_text(
                    'Lalu 3 kegiatan apa yang paling digemari pengunjung? ')
                a = 17
                new_message = 0
            if (a == 17 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '10', msg)
                insert('rptra', query)
                # pertanyaan PKK
                # reply_keyboard = [['Menengah ke bawah'], ['Menengah ke atas']]
                update.message.reply_text(
                    'Menurut hasil survey RPTRA Anda (apabila ada) atau respon dari masyarakat, manfaat apa saja yang dirasakan dengan adanya RPTRA? ')
                a = 18
                new_message = 0
            if (a == 18 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '11', msg)
                insert('rptra', query)
                # pertanyaan PKK
                # reply_keyboard = [['Menengah ke bawah'], ['Menengah ke atas']]
                update.message.reply_text(
                    'Seandainya pemberian dana untuk RPTRA dihentikan dan Anda tidak digaji oleh pemda DKI lagi, kira-kira '
                    'hal apa saja yang akan Anda lakukan agar kegiatan operasional RPTRA tetap berjalan? ')
                a = 19
                new_message = 0
            if (a == 19 and new_message == 1 and position=='/survey'):
                # save last answer
                reglist.append(msg)
                query = 'INSERT INTO survey VALUES (0,{0},{1},\'{2}\')'.format(update.message.chat.id, '12', msg)
                insert('rptra', query)
                update.message.reply_text(
                    'Terima kasih telah melakukan pengisian survey RPTRA')
                a = 0
                new_message = 0
                position='free'
            # end survey reglist[16]

            if position=='free':
                update.message.reply_text('ketik /survey untuk memulai survey \n\n'
                                            'ketik /jurnal untuk memberikan aspirasi, kritik, saran atau curhatanmu \n\n'
                                            'ketik /jurnalku untuk membaca kembali jurnal yang sudah kamu tulis')


    except Exception as e:
        print(e)


def insert(tablename, query):
    # insert database
    try:
        db = MySQLdb.connect("localhost", "root", "", tablename)
        cursor = db.cursor()
        cursor.execute(query)
        db.commit()

    except MySQLdb.Error, e:
        try:
            print "MySQL Error [%d]: %s" % (e.args[0], e.args[1])
            update.message.reply_text("Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
            return None
        except IndexError:
            print "MySQL Error: %s" % str(e)
            update.message.reply_text("Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
            return None
    except TypeError, e:
        print(e)
        update.message.reply_text("Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
        return None
    except ValueError, e:
        print(e)
        update.message.reply_text("Mohon maaf data gagal disimpan. Silakan hubungi administrator 0811123123")
        return None
    finally:
        cursor.close()
        db.close()


if __name__ == '__main__':
    main()
