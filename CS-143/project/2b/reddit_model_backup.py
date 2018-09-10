from __future__ import print_function
from pyspark import SparkConf, SparkContext
from pyspark.sql import SQLContext
from cleantext import sanitize
from pyspark.ml.feature import CountVectorizer
from pyspark.sql.functions import split, col
from pyspark.sql.types import *

# IMPORT OTHER MODULES HERE
def select(ngrams):
	return ngrams[1] + " " + ngrams[2] + " " + ngrams[3]

def vectorize(ngrams):
	unigram = ngrams[1]
	bigram = ngrams[2]
	trigram = ngrams[3]
	unigram_vector = unigram.split(" ")
	bigram_vector = bigram.split(" ")
	trigram_vector = trigram.split(" ")
	ret = unigram_vector + bigram_vector + trigram_vector
	return ret

def check_pos(label):
	if label == 1:
		return 1
	return 0

def check_neg(label):
	if label == -1:
		return 1
	return 0

def main(context):
	"""Main function takes a Spark SQL context."""
	"""Task1"""
	#commentsDF = sqlContext.read.json("comments-minimal.json.bz2")
	#submissionsDF = sqlContext.read.json("submissions.json.bz2")
	#commentsDF.write.parquet("comments.parquet")
	#submissionsDF.write.parquet("submissions.parquet")
	labeledDF = sqlContext.read.format("csv").options(header='true', inferschema='true').load("labeled_data.csv")
	commentsDF = sqlContext.read.parquet("comments.parquet")
	submissionsDF = sqlContext.read.parquet("submissions.parquet")

	"""Task2"""
	#data = labeled_data.join(comments, comments("id")===labeled_data("Input_id"), "inner").select("id","body","labeldem","labelgop","labeldjt")
	commentsDF.createOrReplaceTempView("comments")
	labeledDF.createOrReplaceTempView("labeled_data")
	dataDF = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt FROM comments INNER JOIN labeled_data ON comments.id = labeled_data.Input_id")
	'''drop the temp view to save memory (RAM)'''

	"""Task4"""
	dataDF.createOrReplaceTempView("data")
	sqlContext.udf.register("sanitize_udf", sanitize)
	dataDF = sqlContext.sql("SELECT *, sanitize_udf(body) AS ngrams FROM data")

	"""Task5"""
	dataDF.createOrReplaceTempView("data")
	sqlContext.udf.register("select_udf", select)
	data = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, select_udf(ngrams) AS selected_ngrams FROM data")
	#data = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, vectorize_udf(ngrams) AS vectorized_ngrams FROM data")

	"""Task6A"""
	vectorized_data = data.withColumn("selected_ngrams", split(col("selected_ngrams"), " ").cast(ArrayType(StringType())))
	cv = CountVectorizer(inputCol="selected_ngrams", outputCol="vector", minDF=5.0)
	cv_model = cv.fit(vectorized_data)
	vectorized = cv_model.transform(vectorized_data)
	#vectorized.show(1, truncate=False)

	"""Task6B"""
	vectorized.createOrReplaceTempView("Vectorized")
	sqlContext.udf.register("check_pos", check_pos)
	sqlContext.udf.register("check_neg", check_neg)
	new_vectorized = sqlContext.sql("SELECT id, body, labeldem, labelgop, labeldjt, selected_ngrams, vector, check_pos(labeldjt) AS pos_label, check_neg(labeldjt) AS neg_label FROM Vectorized")
	new_vectorized.show(3, False)


if __name__ == "__main__":
	conf = SparkConf().setAppName("CS143 Project 2B")
	conf = conf.setMaster("local[*]")
	sc   = SparkContext(conf=conf)
	sqlContext = SQLContext(sc)
	sc.addPyFile("cleantext.py")
	main(sqlContext)
